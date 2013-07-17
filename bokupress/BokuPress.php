<?php
namespace bokupress;

require_once realpath(dirname(__DIR__).'/vendor/autoload.php');

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
            $resource->filepath = self::resolvePath($request->getRequestUri());
            return $resource;

        } else if (file_exists($request)) {

            $resource = new Resource();
            $resource->filepath = $request;
            $resource->uri = self::resolveUri($request);
            return $resource;

        }
        return null;
    }

    public static function resolvePath($uri)
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

    public static function resolveUri($path)
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
    public function press()
    {
        self::$app = $this;
        
        $path = realpath($this->c['home_dir']);
        $resource = self::resolveResource($path);

        echo "bokupress press begin.\n";
        echo " resource   :".$resource->filepath."\n";
        echo " output dir :".$this->c['output_dir']."\n";
        
        $this->pressDir($resource);

        echo "bokupress press end.\n";
    }
    
    protected function pressDir($resource)
    {
        $path = $this->resolvePressPath($resource);
        
        if (!file_exists($path)) {
            echo " mkdir      :".$path."\n";
            mkdir($path, 0700);
        }
        
        $indexdone = false;
        
        foreach($resource->getChildren("*") as $child) {
            if ($child->isDir()) {
                $this->pressDir($child);
            } else {
                $this->pressFile($child);
                if ($child->getFilename() == "index") 
                    $indexdone = true;
            }
        }

        if (!$indexdone)
            $this->pressFile($resource);
    }
    
    protected function pressFile($resource)
    {
        self::convert($resource);
        
        $path = $this->resolvePressPath($resource, true);
        file_put_contents($path, $this->render($resource));

        echo " output     :".$path."\n";
    }

    protected function resolvePressPath($resource, $dirtoindex = false)
    {
        $path = str_replace(
                $this->c["home_dir"], 
                $this->c["output_dir"], 
                $resource->filepath);
        
        if ($resource->isFile()) {
            $path = self::replaceExtension($path, ".html");
        }

        if ($resource->isDir() && $dirtoindex) {
            $path .= "/index.html";
        }
        
        return $path;
    }
    
    public static function replaceExtension($source, $extension)
    {
        return preg_replace("/\.[^.]*$/", $extension, $source);
    }
}
