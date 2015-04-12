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
            $content = $this->getThirdLevelSectionContentBySlugs($thirdLevelSlug);
            $this->slug = $thirdLevelSlug;
            if(!$content)
                $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $thirdLevelSlug));
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
    private function getThirdLevelSectionContentBySlugs($subSubSlug, $slug=null, $subSlug=null)
    {
        //We don't need $slug in this part, it have been added just to make code more flexible
        //Maybe client would ask you to make some bread crumbs, and you would like to return not just Content object,
        //but maybe an array with links to previous sections and content of current section

        $section = SectionTable::getInstance()->findOneBy("slug", $subSubSlug);
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


}
