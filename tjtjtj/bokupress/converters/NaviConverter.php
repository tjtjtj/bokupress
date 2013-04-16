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
        
        //home
        $navis[] = array(
            'href' => BokuPress::app()->c['home_uri'],
            'text' => 'Home',
            'class' => ($resource->uri === BokuPress::app()->c['home_uri']
                        || $resource->uri === BokuPress::app()->c['home_uri'].'/'
                        || $resource->uri === BokuPress::app()->c['home_uri'].'/index')
                            ? 'current' 
                            : '',
        );
        
        $dir = new Resource();
        $dir->filepath = BokuPress::app()->c['home_dir'];
        foreach ($dir->getChildren("*", GLOB_ONLYDIR) as $dir) {
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
