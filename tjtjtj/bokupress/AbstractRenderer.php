<?php
namespace tjtjtj\bokupress;

/**
 * AbstractRenderer
 *
 * @author tjtjtj
 */
abstract class AbstractRenderer
{
    /**
     * @param Resource $resource
     */
    abstract public function render($resource);
}
