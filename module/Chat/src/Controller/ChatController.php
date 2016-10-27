<?php

namespace Chat\Controller;

use Chat\Data\MessageFormattedDataInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Chat\Entity\Message;
use Doctrine\ORM\EntityManager;
use Chat\Form\ChatForm;
use Chat\Data\MessageFormattedData;

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
            'messagesData' => $this->getMessageFormattedData($messages),
        ]);
    }

    /**
     * @return ViewModel
     *
     * @throws \Exception
     */
    public function addAction()
    {
        if (!$this->getRequest()->isPost()) {
            throw new \Exception('Only POST method allowed for this action.');
        }

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

        $viewModel = new ViewModel([
            'messagesData' => $this->getMessageFormattedData($messages),
        ]);

        $viewModel->setTerminal(true);

        return $viewModel;
    }

    /**
     * @param $messages
     *
     * @return MessageFormattedDataInterface[]
     *
     * @throws \Exception
     */
    private function getMessageFormattedData($messages) {
        $formattedData = [];

        foreach($messages as $message) {
            if (!($message instanceof Message)) {
                throw new \Exception('Invalid message.');
            }

            $formattedData[] = new MessageFormattedData($message);
        }

        return $formattedData;
    }
}
