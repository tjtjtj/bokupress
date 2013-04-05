<?php
namespace tjtjtj\bokupress;

use \PHPTAL;

/**
 * PhptalRenderder
 *
 * @author tjtjtj
 */
class PhptalRenderder extends AbstractRenderer
{
    public $template;
    public $templateUri;
    
    /**
     * 
     * @param Resource $resource
     * @return String html
     */
    public function render($resource)
    {
        $phptal = new PHPTAL();
        $phptal->setTemplate($this->template);

        $phptal->set('template_uri', $this->templateUri);
        foreach ($resource->getValues() as $k => $v) {
            $phptal->set($k, $v);
        }
        return $phptal->execute();
    }    
}
