<?php

namespace Chat\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Chat\Entity\Message;
use Doctrine\ORM\EntityManager;
use Chat\Form\ChatForm;

class ChatController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $form = new ChatForm();

        $messages = $this->entityManager->getRepository(Message::class)->findBy([], ['createdAt' => 'DESC']);

        return new ViewModel([
            'form' => $form,
            'messages' => $messages,
        ]);
    }

    public function addAction()
    {
    }
}
