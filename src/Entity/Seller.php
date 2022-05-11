<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SellerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellerRepository::class)
 * @ApiResource()
 */
class Seller
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brandName;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $brandPhones = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brandAddress;

    /**
     * @ORM\OneToOne(targetEntity=Account::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $activeSince;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getBrandPhones(): ?array
    {
        return $this->brandPhones;
    }

    public function setBrandPhones(array $brandPhones): self
    {
        $this->brandPhones = $brandPhones;

        return $this;
    }

    public function getBrandAddress(): ?string
    {
        return $this->brandAddress;
    }

    public function setBrandAddress(string $brandAddress): self
    {
        $this->brandAddress = $brandAddress;

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

    public function getActiveSince(): ?\DateTimeImmutable
    {
        return $this->activeSince;
    }

    public function setActiveSince(\DateTimeImmutable $activeSince): self
    {
        $this->activeSince = $activeSince;

        return $this;
    }
}
