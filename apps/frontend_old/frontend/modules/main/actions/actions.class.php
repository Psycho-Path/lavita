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
        $slug = $request->getParameter("slug");
        $subSlug = $request->getParameter("sub_slug");
        $thirdLevelSlug = $request->getParameter("sub_sub_slug");

        $rootSection = SectionTable::getInstance()->findOneBy("parent_id", 0);

        $this->firstLevelSections = SectionTable::getInstance()
            ->createQuery('fls')
            ->select('fls.*')
            ->where('fls.parent_id = ?', $rootSection->getId())
            ->execute();

        $content = null;
        $this->slug = $slug;
        $this->uniqueContent = true;

        if($thirdLevelSlug)
        {
            //It means that this is childless section e.g. Medicine article or News Article
            $content = $this->getThirdLevelSectionContentBySlugs($thirdLevelSlug);
            if(!$content)
                $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $thirdLevelSlug));

            $this->html = $content->getHtml();
            $this->slug = $thirdLevelSlug;
            $this->uniqueContent = $this->determineUniqueStatus($content->getSection());
        }
        else
        {
            //Here we should check for subSlug to determine the level of this section
            if($subSlug)
            {
                //It means that we're in second level section
                $content = $this->getSecondLevelSectionContentBySlugs($subSlug);
                if(!$content)
                    $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $subSlug));

                $this->html = $content->getHtml();
                $this->slug = $thirdLevelSlug;
                $this->uniqueContent = $this->determineUniqueStatus($content->getSection());
            }
            else if($slug)
            {
                //That means that we're in one of first-level sections
                $content = $this->getFirstLevelSectionContentBySlug($slug);
                if(!$content)
                    $content = Section::getForegroundContentSource(SectionTable::getInstance()->findOneBy("slug", $slug));

                $this->html = $content->getHtml();
                $this->slug = $thirdLevelSlug;
                $this->uniqueContent = $this->determineUniqueStatus($content->getSection());
            }
            else
            {
                //if there is no slugs in this url, probably it is the homepage or some mistake
                //anyway we should force user to the homepage

                $this->redirect('main/index');
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
     * @return bool
     */
    private function determineUniqueStatus(Section $object)
    {
        if($object->getType() == "WithHTMLContent")
            return false;
        else
            return true;
    }

    /**
     * This method determines does section contains content or not
     *
     * @return bool
     */
    private function determineContentInclusion(Section $object)
    {
        if($object->getType() == "WithoutContent")
            return false;
        else
            return true;
    }

}
