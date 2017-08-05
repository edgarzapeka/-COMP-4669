<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'authorize' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/authorize',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'authorize',
                    ],
                ],
            ],
            'import' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/import[:code]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'import',
                    ],
                ],
            ],
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'pictures' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/get/pictures',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'getPictures',
                    ],
                ],
            ],
            'pictures-interval' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/get/pictures/[:start:count]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'getPicturesInterval',
                    ],
                ],
            ],
            'comments' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/get/comments[/:pictures_id]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'comments',
                    ],
                ],
            ],
            'search' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/search[/:word]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'strategies' => array('ViewJsonStrategy'),
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
