<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GeneratedRelationsForContentTable extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('content', 'content_section_id_section_id', array(
             'name' => 'content_section_id_section_id',
             'local' => 'section_id',
             'foreign' => 'id',
             'foreignTable' => 'section',
             ));
        $this->addIndex('content', 'content_section_id', array(
             'fields' => 
             array(
              0 => 'section_id',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('content', 'content_section_id_section_id');
        $this->removeIndex('content', 'content_section_id', array(
             'fields' => 
             array(
              0 => 'section_id',
             ),
             ));
    }
}