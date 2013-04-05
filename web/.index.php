<?php
$config = require(realpath(dirname(__DIR__).'/app/config.php'));
//var_dump( $config);

require_once realpath(__DIR__ . '/../tjtjtj/bokupress/BokuPress.php');
$app = new tjtjtj\bokupress\BokuPress($config);
$app->c['base_dir'] = __DIR__;
$app->c['base_uri'] = '/bokupress/web';
$app->c['template_dir'] = __DIR__.'/template';


$app->run();
