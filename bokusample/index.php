<?php
$config = require(realpath(__DIR__.'/config.php'));

$config['home_dir'] = __DIR__;
$config['home_uri'] = '';
//$config['home_uri'] = '/bokusample';

//$config['template_dir'] = $config['home_dir'].'/_watchthis';
//$config['template_uri'] = $config['home_uri'].'/_watchthis';
$config['template_dir'] = $config['home_dir'].'/_template';
$config['template_uri'] = $config['home_uri'].'/_template';

require_once realpath(__DIR__ . '/../tjtjtj/bokupress/BokuPress.php');
$app = new tjtjtj\bokupress\BokuPress($config);
$app->run();
