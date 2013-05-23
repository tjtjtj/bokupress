<?php
namespace bokupress;

require_once realpath(dirname(dirname(__DIR__)).'/vendor/autoload.php');

use bokupress\Resource;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Pimple;

/**
 * AbstractRenderer
 *
 * @author tjtjtj
 */
class BokuPress
{
    public static $app;
    public $c;
    
    public function __construct($config)
    {
        $this->c = new Pimple($config);
        $this->c['request'] = Request::createFromGlobals();
    }
    
    public function run()
    {
        self::$app = $this;
        
        // リクエストからリソースを得る
        $resource = self::resolveResource($this->c['request']);
        if (!$resource) {
            //header("HTTP/1.1 404 Not Found");
            $response = new Response(null, 404);
            //$response = new Response('Not Found', 404);
            $response->send();
            return;
        }

        self::convert($resource);
        
        // レスポンス
        //new Response($this->render($resource))->send();
        $response = new Response($this->render($resource));
        $response->send();
    }

    public static function app()
    {
        return self::$app;
    }

        /**
     * リソース解決
     * 
     * @param Resource $resource
     */
    public static function resolveResource($request)
    {
        if ($request instanceof Request) {
            $resource = new Resource();
            $resource->uri = $request->getRequestUri();
            $resource->filepath = self::getPathFormUri($request->getRequestUri());
            return $resource;

        } else if (file_exists($request)) {

            $resource = new Resource();
            $resource->filepath = $request;
            $resource->uri = self::getUriFormPath($request);
            return $resource;

        }
        return null;
    }

    public static function getPathFormUri($uri)
    {
        $u = ltrim($uri, self::app()->c['home_uri']);
        $path = self::app()->c['home_dir'].'/'.$u;
        $rpath = realpath($path);

        if ($rpath) {
            return $rpath;
        } else {
            foreach (glob($path.'.*') as $filename ) {
                return $filename;
            }
        }
        return null;
    }

    public static function getUriFormPath($path)
    {
        $uri = str_replace(self::app()->c['home_dir'], self::app()->c['home_uri'], $path);
        $uri = str_replace('//', '/', $uri);
        $uri = rtrim($uri, pathinfo($path, PATHINFO_EXTENSION));
        $uri = rtrim($uri, '.');
        return $uri;
    }
    
    /**
     * 
     * @param Resource $resource
     */
    public static function convert($resource)
    {
        foreach(self::$app->c['converters'] as $cnvnm) {
            $cnv = self::$app->c[$cnvnm];
            $cnv->convert($resource);
        }
    }
    
    /**
     * 
     * @param Resource $resource
     */
    public function render($resource)
    {
        $renderer = $this->c['renderer'];
        if (!$renderer) {
            return null;
        }
        return $renderer->render($resource);
    }
}
