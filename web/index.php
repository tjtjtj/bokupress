<?php
$config = require(realpath(dirname(__DIR__).'/app/config.php'));

require_once realpath(__DIR__ . '/../tjtjtj/bokupress/BokuPress.php');
$app = new tjtjtj\bokupress\BokuPress($config);
$app->c['base_dir'] = dirname(dirname(__DIR__));
$app->c['home_dir'] = __DIR__;
$app->c['home_uri'] = '/bokupress/web';
$app->c['template_dir'] = __DIR__.'/_template';
$app->c['template_uri'] = '/bokupress/web/_template';


$app->run();


