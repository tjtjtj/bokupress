<?php
namespace tjtjtj\bokupress;

require_once realpath(dirname(dirname(__DIR__)).'/vendor/autoload.php');

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

    /**
     * リソース解決
     * 
     * @param Resource $resource
     */
    public static function resolveResource($request)
    {
        $resource = null;
        
        if ($request instanceof Request) {
            $resource = new Resource();
            $resource->uri = $request->getRequestUri();
            $path = self::$app->c['base_dir'].$request->getRequestUri();
            $rpath = realpath($path);

            if ($rpath) {
                $resource->filepath = $rpath;
            } else {
                foreach (glob($path.'.*') as $filename ) {
                    $resource->filepath = $filename;
                    //$resource->filepath = pathinfo($filename, PATHINFO_FILENAME);
                    break;
                }
            }
        } else if (file_exists($request)) {
            $resource = new Resource();
            $resource->filepath = $request;
            $resource->uri = str_replace(self::$app->c['home_dir'], self::$app->c['home_uri'], $request);
            $resource->uri = rtrim($resource->uri, pathinfo($request, PATHINFO_EXTENSION));
            $resource->uri = rtrim($resource->uri, '.');
        }
        
        return $resource;
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

