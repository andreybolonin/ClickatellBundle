<?php

namespace Archer\ClickatellBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ArcherClickatellExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('clickatell.user', $config['user']);
        $container->setParameter('clickatell.password', $config['password']);
        $container->setParameter('clickatell.api_id', $config['api_id']);
        $container->setParameter('clickatell.message_class', $config['message_class']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->loadReplyMessage($config, $container, $loader);
        $this->loadSendMessage($config, $container, $loader);
    }

    private function loadReplyMessage(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('reply_message.xml');
        $container->setParameter('clickatell.reply_message.form.name', $config['reply_message']['form']['name']);
        $container->setParameter('clickatell.reply_message.form.type', $config['reply_message']['form']['type']);
        $container->setParameter('clickatell.reply_message.form.validation_groups', $config['reply_message']['form']['validation_groups']);
        $container->setParameter('clickatell.reply_message.form.csrf_protection', $config['reply_message']['form']['csrf_protection']);
    }

    private function loadSendMessage(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $loader->load('send_message.xml');
        $container->setParameter('clickatell.send_message.form.name', $config['send_message']['form']['name']);
        $container->setParameter('clickatell.send_message.form.type', $config['send_message']['form']['type']);
        $container->setParameter('clickatell.send_message.form.validation_groups', $config['send_message']['form']['validation_groups']);
        $container->setParameter('clickatell.send_message.form.csrf_protection', $config['send_message']['form']['csrf_protection']);
    }
}
