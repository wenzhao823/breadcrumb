<?php
define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';

require ROOT_PATH . '/test/application.php';


$bc = new BreadCrumb('Application', 'edit', array('controller_postfix'=>'Controller', 'action_postfix'=>'Action'));
$tpl = $bc->render();

echo $tpl.PHP_EOL;
