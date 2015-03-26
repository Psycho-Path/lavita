<?php
/**
 * Created by PhpStorm.
 * User: AlexanderDupree
 * Date: 21.03.15
 * Time: 19:41
 */
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('admin', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
