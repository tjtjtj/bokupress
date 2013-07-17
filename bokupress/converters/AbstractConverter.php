<?php
namespace bokupress\converters;

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
            $values = $this->doConvert($resource);
            $key = $this->getKey();
            $resource[$key] = $values;
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
