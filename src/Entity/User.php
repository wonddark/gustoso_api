<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"user:collection:read"}}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"user:collection:read"}},
 *              "denormalization_context"={"groups"={"user:collection:write"}}
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_USER')",
 *              "normalization_context"={"groups"={"user:item:read"}}
 *          },
 *          "patch"={
 *              "security"="object.account.id == user.id",
 *              "normalization_context"={"groups"={"user:item:read"}},
 *              "denormalization_context"={"groups"={"user:item:write"}}
 *          },
 *          "delete"={
 *              "security"="object.account.id == user.id",
 *          }
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"account.isActive"})
 * @ApiFilter(ExistsFilter::class, properties={"account.phone"})
 * @ApiFilter(DateFilter::class, properties={"account.registeredAt"})
 * @ApiFilter(SearchFilter::class,
 *     properties={
 *      "firstname"="partial",
 *      "lastname"="partial",
 *      "address"="partial",
 *      "account.email"="partial",
 *      "account.phone"="partial"}
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
     * @Groups("user:collection:read")
     * @Groups("user:item:read")
     * @Groups("user:collection:write")
     * @Groups("user:item:write")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:collection:read")
     * @Groups("user:item:read")
     * @Groups("user:collection:write")
     * @Groups("user:item:write")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user:item:read")
     * @Groups("user:collection:write")
     * @Groups("user:item:write")
     */
    private $address;

    /**
     * @ORM\OneToOne(targetEntity=Account::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("user:item:read")
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

