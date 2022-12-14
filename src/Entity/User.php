<?php

namespace App\Entity;

use App\Enum\RoleTypeEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[Assert\Length(
        min: 6,
        // max: 50,
        minMessage: 'Password must be at least {{ limit }} characters!',
        // maxMessage: 'Your password cannot be longer than {{ limit }} characters',
    )]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255)]
    private ?RoleTypeEnum $type = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $passwordUpdatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $roll = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mobile = null;

    #[ORM\OneToMany(mappedBy: 'user_', targetEntity: BookLend::class)]
    private Collection $bookLends;

    #[ORM\OneToMany(mappedBy: 'user_', targetEntity: BookReturn::class)]
    private Collection $bookReturns;

    public function __construct()
    {
        $this->type = RoleTypeEnum::User;
        $this->bookLends = new ArrayCollection();
        $this->bookReturns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return 'user - ' . $this->email;
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
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        switch ($this->type) {
            case RoleTypeEnum::Admin:
                $roles[] = 'ROLE_ADMIN';
                break;
            case RoleTypeEnum::User:
                $roles[] = 'ROLE_USER';
                break;
        }

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        if ($plainPassword) {
            $this->setPasswordUpdatedAt(new \DateTimeImmutable);
        }

        return $this;
    }

    public function getType(): ?RoleTypeEnum
    {
        return $this->type;
    }

    public function setType(RoleTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPasswordUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->passwordUpdatedAt;
    }

    public function setPasswordUpdatedAt(?\DateTimeImmutable $passwordUpdatedAt): self
    {
        $this->passwordUpdatedAt = $passwordUpdatedAt;

        return $this;
    }

    public function getRoll(): ?string
    {
        return $this->roll;
    }

    public function setRoll(?string $roll): self
    {
        $this->roll = $roll;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * @return Collection<int, BookLend>
     */
    public function getBookLends(): Collection
    {
        return $this->bookLends;
    }

    public function addBookLend(BookLend $bookLend): self
    {
        if (!$this->bookLends->contains($bookLend)) {
            $this->bookLends->add($bookLend);
            $bookLend->setUser($this);
        }

        return $this;
    }

    public function removeBookLend(BookLend $bookLend): self
    {
        if ($this->bookLends->removeElement($bookLend)) {
            // set the owning side to null (unless already changed)
            if ($bookLend->getUser() === $this) {
                $bookLend->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BookReturn>
     */
    public function getBookReturns(): Collection
    {
        return $this->bookReturns;
    }

    public function addBookReturn(BookReturn $bookReturn): self
    {
        if (!$this->bookReturns->contains($bookReturn)) {
            $this->bookReturns->add($bookReturn);
            $bookReturn->setUser($this);
        }

        return $this;
    }

    public function removeBookReturn(BookReturn $bookReturn): self
    {
        if ($this->bookReturns->removeElement($bookReturn)) {
            // set the owning side to null (unless already changed)
            if ($bookReturn->getUser() === $this) {
                $bookReturn->setUser(null);
            }
        }

        return $this;
    }
}
