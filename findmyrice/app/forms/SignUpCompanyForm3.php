<?php
namespace Findmyrice\Forms;

use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;

class SignUpCompanyForm3 extends Form
{

    public function initialize()
    {
        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Register', array(
            'class' => 'register_btn',
            'id'=>'register_btn_box'
        )));
    }



    public function initializeEdit(){

        $this->initializeProfileElements();
        // Sign Up
        $this->add(new Submit('Register', array(
            'class' => 'register_btn',
            'id'=>'register_btn_box'
        )));
    }

    protected function initializeProfileElements(){

        // Key Words
        $key_words = new Text('key_words', array(
            "class"=>"form-control",
            'placeholder' => 'Enter Key Words',
            ));
        $key_words->setLabel('Key Words');
        $this->add($key_words);

        // Key Words Area
        $key_words_area = new TextArea('key_words_area',array(
//            'disabled' => 'true',
            'placeholder' => '',
            "class"=>"form-control"
        ));
        $key_words_area->setLabel('Key Words Area');
        $this->add($key_words_area);
    }

    public function setDefault($fieldName,$value){
        \Phalcon\Tag::setDefault($fieldName, $value);
    }

    protected function setDefaultsFromRequest(\Phalcon\Http\Request $request){
        \Phalcon\Tag::setDefaults(array(
            'key_words_area'     => $request->getPost('key_words_area')
        ));
    }

    public function setDefaultsFromSession($session){
        if(isset($session) && !empty($session)){
            \Phalcon\Tag::setDefaults(array(
                'key_words_area'  => $session['key_words_area']
            ));
        }
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }

}
