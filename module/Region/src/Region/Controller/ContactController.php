<?php

namespace Region\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

use Region\Form\ContactForm;
use Region\Model\Contact;
use Region\Model\ContactTable;
class ContactController extends AbstractActionController
{
    protected $table;
    
    public function getTable()
    {
        if (!$this->table) {
            $sm = $this->getServiceLocator();
            $this->table = $sm->get('Region\Model\ContactTable');
        }

        return $this->table;
    }

    public function indexAction()
    {
    	$form = new ContactForm();

        //var_dump($this->getEvent()->getRouteMatch());
        //$form = new ContactForm($this->getRequest()->getBaseUrl().APPLICATION_PATH.'/data/captcha');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $contact = new Contact();
            $form->setInputFilter($contact->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $contact->exchangeArray($form->getData());
                $this->getTable()->save($contact);
                // Redirect to list of albums
                return $this->redirect()->toRoute('contact');
            }
        }
        return new ViewModel(
        	  array(
             //   'controller' => $this->getEvent()->getRouteMatch()->getParam('__CONTROLLER__'),
              //  'action' => $this->getEvent()->getRouteMatch()->getParam('action'),
                'form' => $form,
            )
    	);
    }

}

