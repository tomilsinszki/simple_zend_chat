<?php

namespace Chat\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Chat\Entity\Message;
use Doctrine\ORM\EntityManager;

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
        $messages = $this->entityManager->getRepository(Message::class)->findAll();

        return new ViewModel([
            'messages' => $messages,
        ]);
    }

    public function addAction()
    {
    }
}
