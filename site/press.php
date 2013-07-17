<?php
$config = require(realpath(__DIR__.'/config.php'));

$config['home_dir'] = __DIR__.'/';
$config['home_uri'] = '/';

$config['template_dir'] = $config['home_dir'].'/_template/';
$config['template_uri'] = '/_template/';

$config['output_dir'] = dirname(__DIR__).'/site_static/';

require_once realpath(__DIR__ . '/../bokupress/BokuPress.php');
$app = new bokupress\BokuPress($config);
$app->press();
