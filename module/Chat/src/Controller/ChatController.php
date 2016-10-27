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
        $messagesData = $this->getMessagesData($messages);

        return new ViewModel([
            'form' => $form,
            'messagesData' => $messagesData,
        ]);
    }

    public function addAction()
    {
        $content = $this->params()->fromPost('content', null);

        if (!empty($content)) {
            $message = new Message();
            $message->setContent($content);
            $this->entityManager->persist($message);
            $this->entityManager->flush();
        }

        $removableMessages = $this->entityManager->getRepository(Message::class)->findBy([], ['createdAt' => 'DESC'], null, 10);
        foreach($removableMessages as $message) {
            $this->entityManager->remove($message);
        }
        $this->entityManager->flush();

        $messages = $this->entityManager->getRepository(Message::class)->findBy([], ['createdAt' => 'DESC']);
        $messagesData = $this->getMessagesData($messages);

        $headers = $this->getResponse()->getHeaders();
        $headers->addHeaderLine("Content-type: application/html");

        $viewModel = new ViewModel([
            'messagesData' => $messagesData,
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    /**
     * @param Message[] $messages
     *
     * @return array
     *
     * @throws \Exception
     */
    private function getMessagesData($messages) {
        $data = [];

        foreach($messages as $message) {
            if (!($message instanceof Message)) {
                throw new \Exception('Invalid message.');
            }

            $data[] = [
                'content' => $message->getContent(),
                'createdAt' => ($message->getCreatedAt() instanceof \DateTime) ? $message->getCreatedAt()->format('Y-m-d H:i:s') : '',
            ];
        }

        return $data;
    }
}
