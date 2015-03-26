<?php
/**
 * Created by PhpStorm.
 * User: AlexanderDupree
 * Date: 21.03.15
 * Time: 14:42
 */
class ContentComponents extends sfComponents{
    function executeNewForm(sfWebRequest $request)
    {
        $contentObject = null;
        $potentialSections = null;
        $obviousSection = null;

        if($request->getParameter("id"))
        {
            $contentObject = ContentTable::getInstance()->findOneBy("id", $request->getParameter("id"));
            var_dump($request->getParameter("id"));
            $obviousSection = SectionTable::getInstance()->findOneBy("id", $contentObject->getSectionId());
            $potentialSections = SectionTable::getInstance()->findBy("parent_id", $obviousSection->getParentId());
        }

        if($request->getParameter("section_id"))
        {
            $obviousSection = SectionTable::getInstance()->findOneBy("id", $request->getParameter("section_id"));
            $potentialSections = SectionTable::getInstance()->findBy("parent_id", $obviousSection->getParentId());
        }

        $this->content = $contentObject;
        $this->section = $obviousSection;
        $this->sectionsList = $potentialSections;
    }
}