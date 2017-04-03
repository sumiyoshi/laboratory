<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Generator\Controller\Index' => 'Generator\Controller\IndexController'
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'table' => array(
                    'options' => array(
                        'route' => 'table',
                        'defaults' => array(
                            'controller' => 'Generator\Controller\Index',
                            'action' => 'table'
                        )
                    )
                ),
                'op' => array(
                    'options' => array(
                        'route' => 'op <table>',
                        'defaults' => array(
                            'controller' => 'Generator\Controller\Index',
                            'action' => 'operation'
                        )
                    )
                ),
                'schema' => array(
                    'options' => array(
                        'route' => 'schema',
                        'defaults' => array(
                            'controller' => 'Generator\Controller\Index',
                            'action' => 'schema'
                        )
                    )
                ),
                'app' => array(
                    'options' => array(
                        'route' => 'app <module>',
                        'defaults' => array(
                            'controller' => 'Generator\Controller\Index',
                            'action' => 'app'
                        )
                    )
                ),
                'controller' => array(
                    'options' => array(
                        'route' => 'con <namespace>',
                        'defaults' => array(
                            'controller' => 'Generator\Controller\Index',
                            'action' => 'controller'
                        )
                    )
                ),
            )
        )
    ),
);
