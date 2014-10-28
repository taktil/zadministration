<?php

class Application_Form_LoginAdmin extends Zend_Form
{
    public function init()
    {
        // initialize form
        $this->setMethod('post')
            ->setAttrib('class', 'admin_login_form');;

        // create text input for name
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Nom d\'utilisateur : ')
                 ->setOptions(array('size' => '30'))
                 ->setRequired(true)
                 // ->addFilter('HTMLEntities')
                 ->setAttrib('class','text-input');


        // create text input for password
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Mot de passe : ')
                 ->setOptions(array('size' => '30'))
                 ->setRequired(true)
                 // ->addFilter('HTMLEntities')
                 ->addFilter('StringTrim')
                 ->setAttrib('class','text-input');

        // create submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Se Connecter')
               ->setOptions(array('class' => 'button'));

        // attach element to form
        $this->addElement($username)
             ->addElement($password)
             ->addElement($submit);
    }
}