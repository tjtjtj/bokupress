<?php

return array(
    'app_dir'=>__DIR__,
    
    // Converters
    'converters'=>array(
        'MarkdownConverter',
        'DirConverter',
        'NaviConverter',
    ),
            
    // Renderer
    'renderer'=>function($container) {
        $r = new tjtjtj\bokupress\PhptalRenderder();
        $r->template = 'C:\xampp\htdocs\BokuPress\web\_template\index.html';
        $r->templateUri = '/bokupress/web/_template';
        $r->title = "title!!!";
        return $r;
    },

    // instances
    'MarkdownParser'=>function() {
        return new dflydev\markdown\MarkdownExtraParser();
    },
    'MarkdownConverter'=>function($container) {
        return new tjtjtj\bokupress\converters\MarkdownConverter($container['MarkdownParser']);
    },
    'DirConverter'=>function() {
        return new tjtjtj\bokupress\converters\DirConverter();
    },
    'NaviConverter'=>function() {
        return new tjtjtj\bokupress\converters\NaviConverter();
    },
    
);