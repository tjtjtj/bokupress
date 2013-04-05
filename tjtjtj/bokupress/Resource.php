<?php
namespace tjtjtj\bokupress;

use tjtjtj\bokupress\StringUtils;

/**
 * Resource
 *
 * @author tjtjtj
 */
class Resource implements \ArrayAccess
{
    public $uri;
    public $filepath;
    protected $values;
    
    public function __construct (array $values = array())
    {
        $this->values = $values;
    }
    
    public function dump()
    {
        var_dump($this->values);
        echo "<br>";
    }
    
    public function offsetSet($id, $value)
    {
        $this->values[$id] = $value;
    }

    public function offsetGet($id)
    {
        if (!array_key_exists($id, $this->values)) {
            throw new InvalidArgumentException(sprintf('Identifier "%s" is not defined.', $id));
        }

        $isFactory = is_object($this->values[$id]) && method_exists($this->values[$id], '__invoke');

        return $isFactory ? $this->values[$id]($this) : $this->values[$id];
    }

    public function offsetExists($id)
    {
        return array_key_exists($id, $this->values);
    }

    /**
     * Unsets a parameter or an object.
     *
     * @param string $id The unique identifier for the parameter or object
     */
    public function offsetUnset($id)
    {
        unset($this->values[$id]);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getFilepath()
    {
        return $this->filepath;
    }

    public function getFilename()
    {
        return pathinfo($this->filepath, PATHINFO_FILENAME);
    }

    public function getExtension()
    {
        return pathinfo($this->filepath, PATHINFO_EXTENSION);
    }

    public function getValues()
    {
        return $this->values;
    }
    
    
    public function isFile()
    {
        return is_file($this->filepath);
    }

    public function isDir()
    {
        return is_dir($this->filepath);
    }

    /**
     * 
     * @param type $pattern
     * @param type $flags
     * @return array
     */
    public function getChildren($pattern='*.*', $flags=0)
    {
        if (!$this->isDir()) {
            return null;
        }
        
        $ret = array();

        foreach (glob($this->filepath.'/'.$pattern, $flags) as $filename ) {
            
            $pathinfo = pathinfo($filename);
            if (isset($pathinfo['extension']) && $pathinfo['extension'] === 'php') {
                continue;
            }
            if (StringUtils::startsWith($pathinfo['filename'], '_')) {
                continue;
            }
            
            $item = BokuPress::resolveResource($filename);
            $ret[]=$item;
        }
        return $ret;
    }

    public function getFileContents()
    {
        return ($this->isFile())
                ? file_get_contents($this->filepath)
                : null;
    }
}
