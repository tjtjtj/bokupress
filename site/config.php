<?php

return array(
    // Converters
    'converters'=>array(
        'MarkdownConverter',
        'DirConverter',
        'NaviConverter',
    ),
            
    // Renderer
    'renderer'=>function($container) {
        $r = new bokupress\PhptalRenderder();
        $r->template = $container['template_dir'].'/index.html';
        $r->templateUri = $container['template_uri'];
        return $r;
    },

    // instances
    'MarkdownParser'=>function() {
        return new dflydev\markdown\MarkdownExtraParser();
    },
    'MarkdownConverter'=>function($container) {
        return new bokupress\converters\MarkdownConverter($container['MarkdownParser']);
    },
    'DirConverter'=>function($container) {
        return new bokupress\converters\DirConverter($container['MarkdownParser']);
    },
    'NaviConverter'=>function() {
        return new bokupress\converters\NaviConverter();
    },
    
);