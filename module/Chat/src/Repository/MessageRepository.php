<?php

namespace Chat\Repository;

use Doctrine\ORM\EntityRepository;
use Chat\Entity\Message;

class MessageRepository extends EntityRepository
{
    /**
     * @return Message[] array
     */
    public function getFromLatestToOldest()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('m')
            ->from(Message::class, 'm')
            ->orderBy('m.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param integer $numberOfNewestMessagesToKeep
     */
    public function removeAllExceptNewests($numberOfNewestMessagesToKeep)
    {
        $removableMessages = $this->getEntityManager()->createQueryBuilder()
                ->select('m')
                ->from(Message::class, 'm')
                ->orderBy('m.createdAt', 'DESC')
                ->setFirstResult($numberOfNewestMessagesToKeep)
                ->getQuery()
                ->getResult();

        foreach($removableMessages as $message) {
            $this->getEntityManager()->remove($message);
        }

        $this->getEntityManager()->flush();
    }
}
