<?php
namespace bokupress\converters;

use bokupress\Resource;
use bokupress\MarkdownUtils;
use dflydev\markdown\IMarkdownParser;

/**
 * Description of DirConverter
 *
 * @author tjtjtj
 */
class DirConverter extends AbstractConverter
{
    protected $file = 'index.md';
    protected $key = 'md';

    /**
     *
     * @var IMarkdownParser 
     */
    protected $parser;

    public function __construct(IMarkdownParser $parser)
    {
        $this->parser = $parser;
    }

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
        foreach($resource->getChildren("index.md") as $res) {
            $this->key = "md";

            //$ret = $this->parser->transformMarkdown($res->getFileContents());
            //return $ret;


            return $this->parser->transformMarkdown($res->getFileContents());
        }

        $this->key = "dir";
        $ret = array();
        foreach ($resource->getChildren() as $child) {
            $contents = $child->getFileContents();
            //$title = 
            //$tagline = 
            $ret[] = array(
                'title'=>MarkdownUtils::getTitle($contents),
                'tagline'=>MarkdownUtils::getTagline($contents),
                'uri'=>$child->uri,
            );
        }
        return $ret;
    }

    /**
     * @return String
     */
    protected function getKey()
    {
        return $this->key;
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
