<?php
namespace tjtjtj\bokupress\converters;
use \dflydev\markdown\IMarkdownParser;

/**
 * Description of MarkdownConverter
 *
 * @author tjtjtj
 */
class MarkdownConverter extends AbstractConverter
{
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
        return $resource->isFile()
               && $resource->getExtension() === "md";
    }

    /**
     * 
     * @param Resource $resource
     * @return Array
     */
    public function doConvert($resource) 
    {
        return $this->parser->transformMarkdown($resource->getFileContents());
    }

    /**
     * @return String
     */
    protected function getKey()
    {
        return 'md';
    }
    
}
