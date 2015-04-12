<?php

/**
 * main actions.
 *
 * @package    Lavita
 * @subpackage main
 * @author     AlexanderDupree
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mainActions extends sfActions
{

    const kSectionError = -1;
    const kEmptySection = 0;
    const kTypicalSection = 1;
    const kUniqueSection = 2;
    const kListSectionWithoutImages = 3;
    const kListSectionWithImages = 4;

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $sectionContent = null;

      $rootSection = SectionTable::getInstance()->findOneBy("parent_id", 0);

      $this->firstLevelSections = SectionTable::getInstance()
          ->createQuery('fls')
          ->select('fls.*')
          ->where('fls.parent_id = ?', $rootSection->getId())
          ->execute();

      //determine nil section
      if($request->getParameter("slug") == null)
      {
          $sectionContent = ContentTable::getInstance()->findOneBy("section_id", $rootSection->getId());
      }

      $this->content = $sectionContent;
      $this->html = $sectionContent->getHtml();
  }
    /**
    This method executes the section
     */
    public function executeSection(sfWebRequest $request)
    {
        if($request->getParameter('feedback_name') &&
            $request->getParameter('feedback_email')) {
            $this->errors = $this->validateForm($request);
        }


            //variables
        $slug = $request->getParameter("slug");
        $subSlug = $request->getParameter("sub_slug");
        $thirdLevelSlug = $request->getParameter("sub_sub_slug");
        $rootSection = SectionTable::getInstance()->findOneBy("parent_id", 0);
        $content = null;
        $this->slug = $slug;
        $this->uniqueContent = true;

        //move it to components
        $this->firstLevelSections = SectionTable::getInstance()
            ->createQuery('fls')
            ->select('fls.*')
            ->where('fls.parent_id = ?', $rootSection->getId())
            ->execute();

        if($thirdLevelSlug) {
            $content = $this->getThirdLevelSectionContentBySlugs($thirdLevelSlug, $subSlug);
            $this->slug = $thirdLevelSlug;
//            if(!$content)
//                $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $thirdLevelSlug));
        }
        else
        {
            if($subSlug) {
                $content = $this->getSecondLevelSectionContentBySlugs($subSlug);
                $this->slug = $subSlug;
                if(!$content)
                    $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $subSlug));
            }
            else if($slug) {
                $content = $this->getFirstLevelSectionContentBySlug($slug);
                $this->slug = $slug;
                if(!$content)
                    $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $slug));
            }
            else {
                $this->redirect('main/index');
            }
        }
        $this->html = $content->getHtml();
        $this->currentSection = $content->getSection();
        $this->firstLevelSection = Section::getFirstLevelSectionForSection($content->getSection());
        $this->firstLevelSubsections = Section::getSubsections($this->firstLevelSection);

        switch($this->determineSectionStatus($content->getSection())){
            case(self::kEmptySection):
                //can not be true
                var_dump($content->getSection()->getId());
                break;
            case(self::kUniqueSection):
                $this->uniqueContent = true;
                $this->setTemplate('unique');
                break;
            case(self::kTypicalSection):
                $this->setTemplate('typical');
                $this->headerTitle = SectionTable::getInstance()->findOneBy("id", $content->getSection()->getParentId());
                break;
            case(self::kListSectionWithoutImages):
                $this->setTemplate('list');
                $this->subSections = Section::getSubsections($content->getSection());
                break;
            case(self::kListSectionWithImages):
                $this->setTemplate('articlesList');
                $this->subSections = Section::getSubsections($content->getSection());
                $this->fileBasePath = ImageValidator::getBaseArticleSRC();
                break;
            default:
                break;
        }
    }

    /**
     * This method grabs content for specified first-level section
     *
     * @return Content
     */
    private function getFirstLevelSectionContentBySlug($slug)
    {
        $section = SectionTable::getInstance()->findOneBy("slug", $slug);
        if(count($section)>0) {
            return ContentTable::getInstance()->findOneBy("section_id", $section->getId());
        }
        else{
            return null;
        }
    }

    /**
     * This method grabs content for specified second-level section
     *
     * @return Content
     */
    private function getSecondLevelSectionContentBySlugs($subSlug, $slug=null)
    {
        //We don't need $slug in this part, it have been added just to make code more flexible
        //Maybe client would ask you to make some bread crumbs, and you would like to return not just Content object,
        //but maybe an array with links to previous sections and content of current section

        $section = SectionTable::getInstance()->findOneBy("slug", $subSlug);
        if(count($section)>0) {
            return ContentTable::getInstance()->findOneBy("section_id", $section->getId());
        }
        else{
            return null;
        }

    }

    /**
     * This method grabs content for specified third-level section
     *
     * @return Content
     */
    private function getThirdLevelSectionContentBySlugs($subSubSlug, $subSlug, $slug=null)
    {
        //We don't need $slug in this part, it have been added just to make code more flexible
        //Maybe client would ask you to make some bread crumbs, and you would like to return not just Content object,
        //but maybe an array with links to previous sections and content of current section

        $section = SectionTable::getInstance()
                    ->createQuery('ts')
                    ->select('ts.*')
                    ->where('ts.slug LIKE ?', $subSubSlug)
                    ->andWhere('ts.parent_id = ?', SectionTable::getInstance()->findOneBy("slug", $subSlug)->getId())
                    ->fetchOne();
        if(count($section)>0) {
            return ContentTable::getInstance()->findOneBy("section_id", $section->getId());

        }
        else{
            return null;
        }
    }

    /**
     * This method determines does section contains unique type or not
     *
     * @return int
     */
    private function determineSectionStatus(Section $object)
    {
        if($object->getType() == "WithoutContent")
            return self::kEmptySection;
        elseif($object->getType() == "WithHTMLContent")
            return self::kTypicalSection;
        elseif($object->getType() == "WithUniqueContent")
            return self::kUniqueSection;
        elseif($object->getType() == "WithListContent")
            if(strpos($object->getSlug(), "article") || strpos($object->getSlug(), "news"))
                return self::kListSectionWithImages;
            else
                return self::kListSectionWithoutImages;
        else
            return self::kSectionError;
    }


    /**
     *  Method validates form values and returns errors or null
     */
    function validateForm(sfWebRequest $request)
    {
        $name = $request->getParameter('feedback_name');
        $visitor_email = $request->getParameter('feedback_email');
        $user_message = $request->getParameter('feedback_message');

        $errors = null;

        ///------------Do Validations-------------
        if(empty($name)||empty($visitor_email))
        {
            $errors .= "\n Name and Email are required fields. ";
        }
        if($this->IsInjected($visitor_email))
        {
            $errors .= "\n Bad email value!";
        }
        if(empty($_SESSION['6_letters_code'] ) ||
            strcasecmp($_SESSION['6_letters_code'], $request->getParameter('6_letters_code')) != 0)
        {
            //Note: the captcha code is compared case insensitively.
            //if you want case sensitive match, update the check above to
            // strcmp()
            $errors .= "\n The captcha code does not match!";
        }

        if(empty($errors))
        {
            //send the email
            $to = "truedupree@gmail.com";
            $subject="Нам оставили отзыв!";
            $from = $visitor_email;
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

            $body = "Пользователь, $name Оставил отзыв:\n".
                "Имя: $name\n".
                "Email: $visitor_email \n".
                "Отзыв: \n ".
                "$user_message\n".
                "IP: $ip\n";

            $headers = "From: $from \r\n";
            $headers .= "Reply-To: $visitor_email \r\n";

            mail($to, $subject, $body,$headers);

//            header('Location: thank-you.html');
            return null;
        }
        else
            return $errors;
    }

    function IsInjected($str)
    {
        $injections = array('(\n+)',
            '(\r+)',
            '(\t+)',
            '(%0A+)',
            '(%0D+)',
            '(%08+)',
            '(%09+)'
        );
        $inject = join('|', $injections);
        $inject = "/$inject/i";
        if(preg_match($inject,$str))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
