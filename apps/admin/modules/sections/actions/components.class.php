<?php
class SectionsComponents extends sfComponents{

    function executeNewform(sfWebRequest $request)
    {
        $sectionObject = null;
        $potentialParentSections = null;
        $obviousParent = null;

        if($request->getParameter("id")) {
            $sectionObject = SectionTable::getInstance()->findOneBy("id", $request->getParameter("id"));
            if ($sectionObject->getParentId()) {
                $obviousParent = SectionTable::getInstance()->findOneBy("id", $sectionObject->getParentId());
                $potentialParentSections = SectionTable::getInstance()->findBy("parent_id", $obviousParent->getParentId());
            }
        }

        if($this->getContext()->getUser()->getAttribute("parent_section_slug")) {
            $obviousParent = SectionTable::getInstance()->findOneBy("slug", $this->getContext()->getUser()->getAttribute("parent_section_slug"));
            $potentialParentSections = SectionTable::getInstance()->findBy("parent_id", $obviousParent->getParentId());
        }

        $this->section = $sectionObject;
        $this->parent = $obviousParent;
        $this->parentsList = $potentialParentSections;
    }
}
?>
