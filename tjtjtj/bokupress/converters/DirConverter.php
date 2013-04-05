<?php
namespace tjtjtj\bokupress\converters;

use tjtjtj\bokupress\Resource;
use tjtjtj\bokupress\MarkdownUtils;

/**
 * Description of DirConverter
 *
 * @author tjtjtj
 */
class DirConverter extends AbstractConverter
{
    /**
     * 
     * @param Resource $resource
     * @return boolean
     */
    public function doFilter($resource) 
    {
        return $resource->isDir();
    }

    /**
     * 
     * @param Resource $resource
     * @return Array
     */
    public function doConvert($resource) 
    {
        $children = array();
        foreach ($resource->getChildren() as $res) {
            $contents = $res->getFileContents();
            $title = $this->getTitle($contents);
            $tagline = $this->getTagline($contents);
            $children[] = array(
                'title'=>$title,
                'tagline'=>$tagline,
                'uri'=>$res->uri,
            );
        }
        return $children;
    }

    /**
     * @return String
     */
    protected function getKey()
    {
        return 'dir';
    }
    
    public function getTitle($contents)
    {
        return MarkdownUtils::getTitle($contents);
    }
    public function getTagline($contents)
    {
        return MarkdownUtils::getTagline($contents);
    }


}
