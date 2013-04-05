<?php
namespace tjtjtj\bokupress;

/**
 * StringUtils
 *
 * @author tjtjtj
 */
class StringUtils 
{
    /**
     * 
     * @param type $haystack
     * @param type $needle
     * @return type
     */
    public static function startsWith($haystack, $needle)
    {
        return strpos($haystack, $needle, 0) === 0;
    }
}
