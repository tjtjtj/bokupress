<?php
namespace tjtjtj\bokupress\converters;

use tjtjtj\bokupress\BokuPress;
use tjtjtj\bokupress\Resource;
use tjtjtj\bokupress\StringUtils;
/**
 * Description of NaviConverter
 *
 * @author tjtjtj
 */
class NaviConverter extends AbstractConverter
{
    /**
     * 
     * @param Resource $resource
     * @return boolean
     */
    public function doFilter($resource) 
    {
        return true;
    }

    public function doConvert($resource)
    {
        $navis = array();

        $navis[] = array(
            'href' => '/bokupress/web/',
            'text' => 'Home',
            'class' => ($resource->uri === '/bokupress/web/'
                        || $resource->uri === '/bokupress/web/index')
                            ? 'active' 
                            : '',
        );
        
        $baseDir = new Resource();
        $baseDir->filepath = BokuPress::$app->c['home_dir'];
        foreach ($baseDir->getChildren("*", GLOB_ONLYDIR) as $dir) {
            $navis[] = array(
                'href'=>$dir->uri,
                'text'=>$dir->getFilename(),
                'class' => (StringUtils::startsWith($resource->uri, $dir->uri))
                            ? 'active' 
                            : '',
            );
        }
        
        return $navis;
    }

    /**
     * @return String
     */
    protected function getKey()
    {
        return 'navi';
    }
   
}
