<?php
namespace Region;
use Region\Model\RegionsTable;
use Region\Model\ContactTable;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;


class Module
{

    public function onBootstrap(MvcEvent $e)
    {

        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array($this, 'loadConfiguration')); 

        
       // var_dump($e->getEvent()->getRouteMatch());
       // var_dump( $e->getRouteMatch());
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),

        );
    }

    public function getServiceConfig()
    {

        return array(
            'factories' => array(
                'Region\Model\RegionsTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RegionsTable($dbAdapter);
                    //$table = new \Region\Model\RegionTable($dbAdapter);
                    return $table;
                },

                'Region\Model\ContactTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ContactTable($dbAdapter);
                    //$table = new \Region\Model\RegionTable($dbAdapter);
                    return $table;
                },
            ),
            
        );

    }

    public function loadConfiguration(MvcEvent $e)
    {
        $application   = $e->getApplication();
        $sm            = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);
        if (null !== $matchedRoute) {
            // I get module name instead of the controller name
            //$this->layout()->username = "tata";
            $e->getViewModel()->setVariable('controller', $matchedRoute->getParam('controller'));
            $e->getViewModel()->setVariable('action', $matchedRoute->getParam('action'));

            $writer = new \Zend\Log\Writer\Stream('log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $logger->info('Controller :'.$matchedRoute->getParam('controller'). ' - Action : '.$matchedRoute->getParam('action'));
            //var_dump($matchedRoute->getParam('controller'));
           // var_dump($matchedRoute->getParam('action'));
           // do something
        }
    } 
}
