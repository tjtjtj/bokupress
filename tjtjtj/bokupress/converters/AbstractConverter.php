<?php
namespace tjtjtj\bokupress\converters;

/**
 * Description of AbstractConverter
 *
 * @author tjtjtj
 */
abstract class AbstractConverter
{
    /**
     * 
     * @param String $key
     * @param Resource $resource
     */
    public function convert($resource)
    {
        if ($this->doFilter($resource)) {
            $resource[$this->getKey()] = $this->doConvert($resource);
        }
    }
    
    /**
     * @param Resource $resource
     * @return boolean
     */
    abstract function doFilter($resource);
    
    /**
     * @param Resource $resource
     * @return Array Description
     */
    abstract protected function doConvert($resource);
    
    /**
     * @return String
     */
    abstract protected function getKey();
}
