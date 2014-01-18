<?php

namespace Region\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Region\Model\RegionsTable;

class IndexController extends AbstractActionController
{
    protected $table;


    public function getTable()
    {
        if (!$this->table) {
            $sm = $this->getServiceLocator();
            $this->table = $sm->get('Region\Model\RegionsTable');
        }

        return $this->table;
    }

    public function indexAction()
    {
        $data = $this->getTable()->select() ;   


        foreach ($data as $row) {
            echo $row->RegionLabel . PHP_EOL;
        }

        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
            )
        );
        
    }

    public function addAction()
    {
        

        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action')
            )
        );
    }

    public function editAction()
    {
        

        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action')
            )
        );
    }

    public function deleteAction()
    {
        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action')
            )
        );
    }


}

