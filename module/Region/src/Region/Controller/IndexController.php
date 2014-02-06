<?php

namespace Region\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Region\Model\RegionsTable;
use Region\Form\RegionForm;
use Region\Model\Region;
use Zend\Tag\Cloud;

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
        $data = $this->getTable()->fetchEntries();

      

            //On définit la vue du paginator
            //PaginationControl::setDefaultViewPartial('pagination/list.phtml');
          //  $data = $this->getTable()->getMovies();

         //echo $_GET['page'];
         $paginator = $this->getTable()->getData();
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
       //  $paginator->setCurrentPageNumber($this->params()->fromRoute(1));
         $paginator->setItemCountPerPage(2);

        

     
            

        $data = $this->getTable()->fetchEntries();
        //var_dump($data);
  
        /*$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($tagArray));

        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));*/
        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
                'result' => $data,
                'paginator' => $paginator,
                'route' => 'region',
               // 'paginator', $paginator
                
            )
        );
        
    }

    public function addAction()
    {

        $form = new RegionForm();
        // On récupère l'objet Request
        $request = $this->getRequest();

        if ($request->isPost()) {
            $region = new Region();
            $form->setInputFilter($region->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $region->exchangeArray($form->getData());
                $this->getTable()->save($region);
                // Redirect to list of albums
                return $this->redirect()->toRoute('region');
            }
        }
        

        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
                'form' => $form,
            )
        );
    }

    public function editAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParams('edit');
        $data = $this->getTable()->fetchEntry(array('RegionId' => $id['id']));

        $form = new RegionForm();
        $form->setData(array('RegionId' => $data->_regionId,'RegionLabel' => $data->_regionLabel,'RegionWeight' => $data->_regionWeight));
        // On récupère l'objet Request
        $request = $this->getRequest();

        if ($request->isPost()) {
            $region = new Region();
            $form->setInputFilter($region->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $region->exchangeArray($form->getData());
                $this->getTable()->save($region);
                // Redirect to list of albums
                return $this->redirect()->toRoute('region');
            }
        }
        //$data = $this->getTable()->delete2($id['id']);

        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
                'form' => $form,
            )
        );
    }

    public function deleteAction()
    {
        $id = $this->getEvent()->getRouteMatch()->getParams('delete');
        $data = $this->getTable()->delete2($id['id']);
        $this->redirect()->toRoute('region');
        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action')
            )
        );
    }

    public function tagAction(){

        $data = $this->getTable()->fetchEntries();

        foreach ($data as $row) {
             $foo['title'] = $row->_regionLabel;
             $foo['weight'] = $row->_regionWeight;
             $foo['params'] = array('url' => '/index/tag/'.$row->_regionLabel);

             $tagArray[] = $foo;    
        }
        $cloud = new Cloud(array('tags' => $tagArray));
        return new ViewModel(
            array(
                'tag' => $cloud,
            )
        );
    }


}

