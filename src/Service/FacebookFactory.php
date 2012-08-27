<?php

namespace Zf2mFacebook\Service;

use InvalidArgumentException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FacebookFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration');
        $config = $config['facebook'];

        if (!($config['config']['appId'] && $config['config']['secret'])) {
        	throw new InvalidArgumentException('Facebook configuration data \'appId\' and \'secret\' must bedefined in config');
        }
        
        $facebook = new Facebook($config['config']);
        
        if($config['config']['setAppIdInHeadScript'])
        {
        	$script = sprintf('var FB_APP_ID = "%s";', $config['config']['appId']);
        	$view = $serviceLocator->get('view');
        	$headScript = $view->plugin('HeadScript');
        	$headScript->prependScript($script);
        }

        return $facebook;
    }
}