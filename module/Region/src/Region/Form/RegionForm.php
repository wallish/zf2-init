<?php
    namespace Region\Form;
    use Zend\Form\Form;
    
    
    // Notre class CategoryForm étend l'élément \Zend\Form\Form; 
    class RegionForm extends Form
    {
        public function __construct($name = null)
        {
            // On ne veut pas tenir compte du parametre $name,
            // On va le surcharger via le contructeur du parent
            parent::__construct('Region');
            
            // On définit la méthode d'envoie du formulaire en POST 
            $this->setAttribute('method', 'post');
            
            // Le champs caché id_category
            $this->add(array(
                'name' => 'RegionId', // Nom du champ
                'type' => 'Hidden',      // Type du champ
            ));
            
            // Le champs name, de type Text
            $this->add(array(
                'name' => 'RegionLabel',       // Nom du champ
                'type' => 'Text',       // Type du champ
                'attributes' => array(
                    'id'    => 'RegionLabel'   // Id du champ
                ),
                'options' => array(
                    'label' => 'RegionLabel',   // Label à l'élément
                ),
            ));

            // Le champs name, de type Text
            $this->add(array(
                'name' => 'RegionWeight',       // Nom du champ
                'type' => 'Text',       // Type du champ
                'attributes' => array(
                    'id'    => 'RegionWeight'   // Id du champ
                ),
                'options' => array(
                    'label' => 'RegionWeight',   // Label à l'élément
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
        }
    }