<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
      'driver'         => 'Pdo',
      'dsn'            => 'mysql:dbname=zf2-init;host=localhost;',
      'username'       => "root", //here I added my valid username 
      'password'       => "", //here I added my valid password
      'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ), 
   ),
      /*'service_manager' => array(
        'factories' => array(
             // le servicemanager Zend DB Adapter qui gére la connexion vers la db  
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),*/
    /*'routes' => array(
      'paginator' => array(
          'type' => 'segment',
          'options' => array(
              'route' => '/list/[page/:page]',
              'defaults' => array(
                  'page' => 1,
              ),
          ),
      ),
  ),*/
);
