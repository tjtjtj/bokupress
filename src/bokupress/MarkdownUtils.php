<?php
namespace bokupress;

/**
 * MarkdownUtils
 *
 * @author tjtjtj
 */
class MarkdownUtils
{
    public static function getMetadata($text)
    {
        $metadata = array();
        foreach(explode("\n", $text) as $line) {
            if (preg_match('^([a-zA-Z0-9][0-9a-zA-Z _-]*?):\s*(.*)$', $lines)) {
                list($key, $value) = explode(":", $line, 1);
                $metadata[rtrim($key)] = trim($value);
            } else {
                break;
            }
        }
        return $metadata;
    }
    
    public static function getTitle($src)
    {
        $ret = "";
        $pattern = '/^.*\n(=+|-+)/m';
        if (preg_match($pattern, $src, $match)) {
            $src2=$match[0];
            $pattern = '/.*[^$]/mi';
            if (preg_match($pattern, $src2, $match)) {
                $ret = $match[0];
            }
        }
        return $ret;
    }
    public static function getTagline($src)
    {
        $ret = "";
        $pattern = '/^(?!(=|-|\||#)).*\n(?!(=|-))/m';
        if (preg_match_all($pattern, $src, $match)) {
            foreach ($match[0] as $v) {
                $ret= trim($v);
                if (!empty($ret)) {
                    break;
                }
            }
        }
        return $ret;
    }
}
