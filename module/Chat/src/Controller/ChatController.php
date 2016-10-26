<?php

namespace Chat\Controller;

use Zend\Json\Json;
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

    /**
     * ChatController constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ViewModel
     */
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

        $result = ['one' => 'one', 'two' => 'two'];

        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine("Content-type: application/json");

        return $this->getResponse()->setContent(Json::encode($result));
    }
}
