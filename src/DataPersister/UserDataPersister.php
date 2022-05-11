<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class UserDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @inheritDoc
     * @param $data User
     */
    public function persist($data)
    {
        /** @noinspection PhpParamsInspection */
        $data->setAccount($this->security->getUser());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}