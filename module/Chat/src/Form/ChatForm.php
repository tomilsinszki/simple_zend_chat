<?php

namespace Chat\Form;

use Zend\Form\Form;

class ChatForm extends Form
{
    public function __construct()
    {
        parent::__construct('chat-form');
        $this->addElements();
    }

    private function addElements()
    {
        $this->add([
            'name' => 'content',
            'type' => 'text',
            'attributes' => [
                'id' => 'message-content-input',
                'placeholder' => "Let's type something here!",
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'id' => 'message-send-button',
                'value' => 'Send',
            ],
        ]);
    }
}