<?php
namespace bokupress\converters;

use bokupress\BokuPress;
use bokupress\Resource;
use bokupress\StringUtils;

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
                            ? 'active' 
                            : '',
        );
        
        $dir = new Resource();
        $dir->filepath = BokuPress::app()->c['home_dir'];
        foreach ($dir->getChildren("*", GLOB_ONLYDIR) as $d) {
            $navis[] = array(
                'href'=>$d->uri,
                'text'=>$d->getFilename(),
                'class' => (StringUtils::startsWith($resource->uri, $d->uri))
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
