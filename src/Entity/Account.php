<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "normalization_context"={"groups"={"account:read"}}
 *         },
 *         "post"={
 *             "path"="/register",
 *             "security"="!is_granted('IS_AUTHENTICATED_FULLY')",
 *             "normalization_ontext"={"groups"={"account:read"}}
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "security"="is_granted('ROLE_ADMIN')",
 *             "normalization_context"={"groups"={"account:read"}}
 *         },
 *         "patch"={
 *             "security"="object == user",
 *             "denormalization_context"={"groups"={"account:update"}}
 *         },
 *         "delete"={
 *             "path"="/unregister/{id}",
 *             "security"="object.id == user.id or is_granted('ROLE_ADMIN')"
 *         }
 *     },
 *     normalizationContext={"groups"={"account:read"}},
 *     denormalizationContext={"groups"={"account:write"}}
 * )
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 */
class Account implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("account:read")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("account:read")
     * @Groups("account:write")
     * @SerializedName("username")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("account:read")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @SerializedName("password")
     * @Groups("account:write")
     * @Groups("account:update")
     * @var string The plain password
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("account:read")
     */
    private $isActive = false;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $activationCode;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("account:read")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $invalidateActivationCodeAt;

    /**
     * @ORM\Column(type="string", length=8, nullable=true, unique=true)
     * @Groups("account:read")
     * @Groups("account:write")
     * @Groups("account:update")
     */
    private $phone;

    public function __construct()
    {
        $this->isActive = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getActivationCode(): ?string
    {
        return $this->activationCode;
    }

    public function setActivationCode(?string $activationCode): self
    {
        $this->activationCode = $activationCode;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getInvalidateActivationCodeAt(): ?\DateTimeImmutable
    {
        return $this->invalidateActivationCodeAt;
    }

    public function setInvalidateActivationCodeAt(\DateTimeImmutable $invalidateActivationCodeAt): self
    {
        $this->invalidateActivationCodeAt = $invalidateActivationCodeAt;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
