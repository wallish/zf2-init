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
}
