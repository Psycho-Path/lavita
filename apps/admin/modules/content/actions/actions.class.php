<?php

/**
 * content actions.
 *
 * @package    Lavita
 * @subpackage content
 * @author     AlexanderDupree
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contentActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->contents = Doctrine_Core::getTable('Content')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
//    $this->form = new ContentForm();

  }

  public function executeCreate(sfWebRequest $request)
  {
      $requestParams = array(
          Content::kSectionIdKey => $request->getParameter("section_id"),
          Content::kHTMLKey => $request->getParameter("html"),
          Content::kVisibilityKey => $request->getParameter("visibility")
      );

      //save new record
      Content::createNewContentWithParams($requestParams);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
      //empty
  }

  public function executeUpdate(sfWebRequest $request)
  {
      $requestParams = array(
          Content::kIdKey => $request->getParameter("id"),
          Content::kSectionIdKey => $request->getParameter("section_id"),
          Content::kHTMLKey => $request->getParameter("html"),
          Content::kVisibilityKey => $request->getParameter("visibility")
      );

      //update record
      Content::updateContentWithParams($requestParams);


      $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //delete record
      Content::deleteContentWithIdentifier($request->getParameter("id"));

    $this->redirect('sections/index');
  }
}
