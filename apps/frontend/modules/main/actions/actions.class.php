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
}
