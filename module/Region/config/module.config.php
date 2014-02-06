<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Region\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            /*'add' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Region\Controller\Index',
                        'action'     => 'add',
                    ),
                ),
            ),*/

            'paginator' => array(
                  'type' => 'segment',
                  'options' => array(
                      'route' => '/region/[page/:page]',
                      'defaults' => array(
                          'page' => 1,
                      ),
                  ),
            ),

            'contact' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/region/[:controller[/:action]][/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Region\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'page' => 1,
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'region' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/region/[:controller[/:action]][/:id][/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Region\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'page' => 1,
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]][/:id][page/:page]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    



    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
           //'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
         'factories' => array(
             // le servicemanager Zend DB Adapter qui gére la connexion vers la db  
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),

    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),


    'controllers' => array(
        'invokables' => array(
            'Region\Controller\Index' => 'Region\Controller\IndexController',
            'Region\Controller\Contact' => 'Region\Controller\ContactController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'region/index/index' => __DIR__ . '/../view/region/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
             'region/partial/pagination' => __DIR__ . '/../view/region/partial/pagination.phtml',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

);
