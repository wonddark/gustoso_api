<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"user:read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"user:read"}}
 *          }
 *     },
 *     itemOperations={
 *          "get",
 *          "patch"={
 *              "security"="object.account.id == user.id",
 *              "normalization_context"={"groups"={"user:read"}}
 *          },
 *          "delete"={
 *              "security"="object.account.id == user.id",
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:read")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=Account::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }
}

