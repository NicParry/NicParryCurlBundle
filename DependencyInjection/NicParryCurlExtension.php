<?php
namespace NicParry\Bundle\CurlBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class NicParryCurlExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        $config['create_mock'] = isset($configs[0]['create_mock']) ? $configs[0]['create_mock'] : false;
        $config['use_mock'] = isset($configs[0]['use_mock']) ? $configs[0]['use_mock'] : false;
        $config['dir_name'] = isset($configs[0]['dir_name']) ? $configs[0]['dir_name'] : "%kernel.root_dir%/CurlMocks";
        $config['user_agent'] = isset($configs[0]['user_agent']) ? $configs[0]['user_agent'] : "Chrome";
        $config['cookie_file'] = isset($configs[0]['cookie_file']) ? $configs[0]['cookie_file'] : "cookies.txt";
        $config['follow_redirects'] = isset($configs[0]['follow_redirects']) ? $configs[0]['follow_redirects'] : true;
        $config['referrer'] = isset($configs[0]['referrer']) ? $configs[0]['referrer'] : "Referrer";
        $config['options'] = isset($configs[0]['options']) ? $configs[0]['options'] : array();
        $config['headers'] = isset($configs[0]['headers']) ? $configs[0]['headers'] : array();

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $container->setParameter('nicparrycurlbundle.create_mock', $config['create_mock']);
        $container->setParameter('nicparrycurlbundle.use_mock', $config['use_mock']);
        $container->setParameter('nicparrycurlbundle.dir_name', $config['dir_name']);
        $container->setParameter('nicparrycurlbundle.user_agent', $config['user_agent']);
        $container->setParameter('nicparrycurlbundle.cookie_file', $config['cookie_file']);
        $container->setParameter('nicparrycurlbundle.follow_redirects', $config['follow_redirects']);
        $container->setParameter('nicparrycurlbundle.referrer', $config['referrer']);
        $container->setParameter('nicparrycurlbundle.options', $config['options']);
        $container->setParameter('nicparrycurlbundle.headers', $config['headers']);

        $loader->load('service.xml');

    }
}