<?php

$app_dir = dirname(dirname(dirname(dirname(__FILE__)))).'/module/App';

return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'zfctwig' => array(
        'extensions' => array(
            'form' => 'Component\Library\TwigExtension\Form'
        )
    ),
    'translator' => array(
        'locale' => 'ja_IP',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => $app_dir . '/view/layout/layout.twig',
            'error/404' => $app_dir . '/view/error/404.twig',
            'error/index' => $app_dir . '/view/error/index.twig',
        ),
        'template_path_stack' => array(
            $app_dir . '/view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
