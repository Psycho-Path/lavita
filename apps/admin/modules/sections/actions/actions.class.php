<?php

/**
 * sections actions.
 *
 * @package    Lavita
 * @subpackage sections
 * @author     AlexanderDupree
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sectionsActions extends sfActions
{


    const kNilLevel = null;
    const kFirstLevel = "first_level";


    /**
     * Метод отвечающий за отображение
     * Списка разделов
     */
    public function executeIndex(sfWebRequest $request)
    {

        $this->sections = null;
        $this->path = null;
        $this->showNavigationBar = true;
        $this->slug = $request->getParameter("slug");

        if ($request->getParameter("slug") == self::kNilLevel) {
            $this->sections = $this->showNilLevel();
            $this->showNavigationBar = false;
        } elseif ($request->getParameter("slug") == self::kFirstLevel) {
            $this->sections = $this->showFirstLevel($request->getParameter("slug"));
            $this->path = "Главная/";
            $this->showNavigationBar = false;
        } else {
            $sectionInfo = $this->showSecondAndMoreLevel($request->getParameter("slug"));
            $this->sections = $sectionInfo['sections'];
            $this->path = $sectionInfo['path'];
        }
    }
    /**
        Достаем раздел нулевого уровня
     */
    function showNilLevel()
    {
        return SectionTable::getInstance()
            ->createQuery('a')
            ->where('a.parent_id = ?', 0)
            ->execute();
    }

    /**
        Достаем разделы первого уровня
     */
    function showFirstLevel($slug)
    {
        $nilLevelSection = $this->showNilLevel();

        return SectionTable::getInstance()
            ->createQuery('a')
            ->where('a.parent_id = ?', $nilLevelSection[0]->getId())
            ->execute();
    }

    /**
        Достаем разделы второго и более уровня
     *
     * @return array()
     */
    function showSecondAndMoreLevel($slug)
    {
        $parentSection = Doctrine_Core::getTable('Section')
            ->createQuery('a')
            ->where('a.slug = ?', $slug)
            ->fetchOne();

        if(count($parentSection) == 0)
        {
            $this->redirect('sections/error');
        }

        $parentPath = "";
        if($parentSection->getParentId())
        {
            //Находим имя прародителя.
            $grandParent = Doctrine_Core::getTable('Section')
                ->createQuery('a')
                ->select('a.name')
                ->where('a.id = ?', $parentSection->getParentId())
                ->fetchOne();
            $parentPath = $grandParent->getName()."/".$parentSection->getName()."/";
        }
        else
        {
            $parentPath = $parentSection->getName();
        }

        $sectionList = SectionTable::getInstance()
            ->createQuery('a')
            ->where('a.parent_id = ?', $parentSection->getId())
            ->execute();

        $result = array(
            "path" => $parentPath,
            "sections" => $sectionList
        );

        return $result;
    }

    public function executeError()
    {
        $this->controller = $this;
    }


  public function executeNew(sfWebRequest $request)
  {
      if($request->getParameter("parent"))
          $this->getContext()->getUser()->setAttribute("parent_section_slug", $request->getParameter("parent"));

      $this->getContext()->getUser()->setAttribute('back_url', $request->getReferer());
  }

  public function executeCreate(sfWebRequest $request)
  {
      $imageName = null;
      if(isset($_FILES["image"]))
        $imageName = ImageValidator::validateFile($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], ImageValidator::kArticleType);

      if($imageName)
          ImageValidator::uploadFile($_FILES["image"]["tmp_name"], $imageName);

      $requestParams = array(
          Section::kNameKey => $request->getParameter("name"),
          Section::kSlugKey => $request->getParameter("slug"),
          Section::kParentIdKey => $request->getParameter("parent_id"),
          Section::kTypeKey => $request->getParameter("type"),
          Section::kPriorityKey => $request->getParameter("priority"),
          Section::kImageKey => $imageName
      );

      Section::createNewSectionWithParams($requestParams);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
      $this->getContext()->getUser()->setAttribute('back_url', $request->getReferer());
      $this->getContext()->getUser()->setAttribute('parent_section_slug', null);
      $this->sectionId = $request->getParameter("id");
  }

  public function executeUpdate(sfWebRequest $request)
  {
      $this->sectionId = $request->getParameter("id");
      $imageName = SectionTable::getInstance()->findOneBy("id", $request->getParameter("id"))->getImage();

      if(isset($_FILES["image"]) && $_FILES["image"]) {
          $imageName = ImageValidator::validateFile($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], ImageValidator::kArticleType);
          if($imageName)
              ImageValidator::uploadFile($_FILES["image"]["tmp_name"], $imageName);
      }

      $requestParams = array(
          Section::kIdKey => $request->getParameter("id"),
          Section::kNameKey => $request->getParameter("name"),
          Section::kSlugKey => $request->getParameter("slug"),
          Section::kParentIdKey => $request->getParameter("parent_id"),
          Section::kTypeKey => $request->getParameter("type"),
          Section::kPriorityKey => $request->getParameter("priority"),
          Section::kImageKey => $imageName
        );

      Section::updateSectionWithParams($requestParams);

      $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
      Section::deleteSectionWithIdentifier($request->getParameter("id"));

      $this->redirect('sections/index');
  }

//  protected function processForm(sfWebRequest $request, sfForm $form)
//  {
//    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
//    if ($form->isValid())
//    {
//      $section = $form->save();
//
//      $this->redirect('sections/edit?id='.$section->getId());
//    }
//  }
}
