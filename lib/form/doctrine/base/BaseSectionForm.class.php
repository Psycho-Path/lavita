<?php

/**
 * Section form base class.
 *
 * @method Section getObject() Returns the current form's model object
 *
 * @package    Lavita
 * @subpackage form
 * @author     AlexanderDupree
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSectionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'slug'       => new sfWidgetFormInputText(),
      'parent_id'  => new sfWidgetFormInputText(),
      'type'       => new sfWidgetFormChoice(array('choices' => array('WithoutContent' => 'WithoutContent', 'WithUniqueContent' => 'WithUniqueContent', 'WithHTMLContent' => 'WithHTMLContent', 'WithListContent' => 'WithListContent'))),
      'priority'   => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'slug'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'parent_id'  => new sfValidatorInteger(array('required' => false)),
      'type'       => new sfValidatorChoice(array('choices' => array(0 => 'WithoutContent', 1 => 'WithUniqueContent', 2 => 'WithHTMLContent', 3 => 'WithListContent'), 'required' => false)),
      'priority'   => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('section[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Section';
  }

}
