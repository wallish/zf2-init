<?php
namespace Region\Form;

use Zend\Form\Form;
use Zend\Captcha;
use Zend\Captcha\AdapterInterface as CaptchaAdapter;
    
// Notre class CategoryForm étend l'élément \Zend\Form\Form; 
class ContactForm extends Form
{
    // protected $captcha;
    public function __construct($name = null)
    {
        
        parent::__construct('Region');
       
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'ContactId', 
            'type' => 'Hidden',      
        ));

       
        $this->add(array(
            'name' => 'ContactPhone',      
            'type' => 'text',       
            'attributes' => array(
                'id'    => 'ContactPhone'   
            ),
            'options' => array(
                'label' => 'ContactPhone',   
            ),
        ));
        
        $this->add(array(
            'name' => 'ContactMail',       
            'type' => 'Text',       
            'attributes' => array(
                'id'    => 'ContactMail'   
            ),
            'options' => array(
                'label' => 'ContactMail',   
            ),
        ));
        
/*
        $dirdata = './data';
        $captchaImage = new CaptchaImage(  array(
                'font' => $dirdata . '/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3)
        );
        $captchaImage->setImgDir($dirdata.'/captcha');
        $captchaImage->setImgUrl($name);

 
        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => $captchaImage,
            ),
        ));
*/
       $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human.',
                'captcha' => new Captcha\Figlet(),

            ),
           'attributes' => array(     // On va définir quelques attributs
                'font-size' => '10px',  // comme la valeur
            ),
        ));

        // Le bouton Submit
        $this->add(array(
            'name' => 'submit',        // Nom du champ
            'type' => 'Submit',        // Type du champ
            'attributes' => array(     // On va définir quelques attributs
                'value' => 'Ajouter',  // comme la valeur
                'id' => 'submit',      // et l'id
            ),
        ));
        /*$this->add(array(     
'type' => 'Zend\Form\Element\Select',       
'name' => 'usernames',
'attributes' =>  array(
    'id' => 'usernames',                
    'options' => array(
        'test' => 'Hi, Im a test!',
        'Foo' => 'Bar',
    ),
),
'options' => array(
    'label' => 'User Name',
),
)); */   
    }
}