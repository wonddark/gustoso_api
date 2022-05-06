<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Account;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountDataPersister implements DataPersisterInterface
{
    private $entityManager;
    private $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof Account;
    }

    /**
     * @inheritDoc
     * @param $data Account
     */
    public function persist($data)
    {
        if ($data->getPlainPassword()) {
            $data->setPassword($this->userPasswordHasher->hashPassword($data, $data->getPlainPassword()));
            $data->eraseCredentials();
        }

        $data->setActivationCode(md5("waiting_for_confirmation_{$data->getEmail()}}" . (new DateTime())->format('s')));
        $data->setRegisteredAt(DateTimeImmutable::createFromMutable(new DateTime()));
        $data->setInvalidateActivationCodeAt(DateTimeImmutable::createFromMutable((new DateTime())->
        add(new DateInterval('PT32H'))));

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
