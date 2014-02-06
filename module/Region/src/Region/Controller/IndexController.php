<?php

namespace Region\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Region\Model\RegionsTable;
use Region\Form\RegionForm;
use Region\Model\Region;
use Zend\Tag\Cloud;
require_once ('./config/spyc-master/Spyc.php');
use ZendService\Flickr\Exception\ExceptionInterface as FlickrException;
use ZendService\Flickr\Flickr;
// use Zend\Config;

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
        //var_dump($this->getEvent()->getRouteMatch()->getParams('page'));
         //echo $_GET['page'];
         $paginator = $this->getTable()->getData();
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page'));
       //  $paginator->setCurrentPageNumber($this->params()->fromRoute(1));
         $paginator->setItemCountPerPage(2);


        // ==== flickr images
        $flickr = new Flickr('5022e42055206da0291361166f1f3a80');
        $results = $flickr->userSearch("yankss78@yahoo.fr");
        $data   = simplexml_load_string($results);
        $photos = $data->photos->photo;
        // foreach($data->photos->photo as $photo){
        //     echo "<img src='http://farm".$photo['farm'].".staticflickr.com/".$photo['server']."/".$photo['id']."_".$photo['secret'].".jpg' />";
        // }
        // var_dump($data->photos->photo[0]);
        // var_dump($data->photos);
        // echo "<img src='http://farm".$data->photos->photo[0]['farm'].".staticflickr.com/".$data->photos->photo[0]['server']."/".$data->photos->photo[0]['id']."_".$data->photos->photo[0]['secret'].".jpg' />";

  
        return new ViewModel(
            array(
                'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
                'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
                'result' => $data,
                'paginator' => $paginator,
                'route' => 'region',
                'photos' => $photos,
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

    public function tagAction()
    {

        $data = $this->getTable()->fetchEntries();
        if(count($data) != 0){
            foreach ($data as $row) {
                 $foo['title'] = $row->_regionLabel;
                 $foo['weight'] = $row->_regionWeight;
                 $foo['params'] = array('url' => '/index/tag/'.$row->_regionLabel);

                 $tagArray[] = $foo;    
            }
            $cloud = new Cloud(array('tags' => $tagArray));
        }else{
            $cloud = null;
        }
        
        return new ViewModel(
            array(
                'tag' => $cloud,
            )
        );
    }

    public function configAction(){

        $type = "";
        if(isset($_POST['type']) && $_POST['type'] == "ini"){
            $reader = new \Zend\Config\Reader\Ini();
            $data   = $reader->fromFile('./config/autoload/global.ini');

            echo "<h2>File global.ini loaded</h2>";
            var_dump($data);
        }
        if(isset($_POST['type']) &&$_POST['type'] == "xml"){
            $reader = new \Zend\Config\Reader\Xml();
            $data   = $reader->fromFile('./config/autoload/global.xml');
            echo "<h2>File global.xml loaded</h2>";
            var_dump($data);

        }
        if(isset($_POST['type']) &&$_POST['type'] == "json"){
            $reader = new \Zend\Config\Reader\Json();
            $data   = $reader->fromFile('./config/autoload/global.json');
            echo "<h2>File global.json loaded</h2>";
            var_dump($data);

        }
        if(isset($_POST['type']) &&$_POST['type'] == "yaml"){
             
            $reader = new \Zend\Config\Reader\Yaml(array('Spyc','YAMLLoadString'));
            $data   = $reader->fromFile('./config/autoload/global.yaml');
            echo "<h2>File global.yaml loaded</h2>";
            var_dump($data);

        }

       
    }

    public function flickrAction(){
         // ==== flickr images
        $flickr = new Flickr('5022e42055206da0291361166f1f3a80');
        $results = $flickr->userSearch("yankss78@yahoo.fr");
        $data   = simplexml_load_string($results);
        $photos = $data->photos->photo;
        return new ViewModel(
            array(
                'photos' => $photos,
               // 'paginator', $paginator
                
            )
        );
    }


}

