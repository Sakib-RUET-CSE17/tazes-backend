<?php

namespace App\Entity;

use App\Repository\BookLendRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookLendRepository::class)]
class BookLend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookLends')]
    private ?User $user_ = null;

    #[ORM\OneToMany(mappedBy: 'bookLend', targetEntity: BookByTazesId::class)]
    private Collection $books;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfLend = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString()
    {
        return 'lend-' . $this->id . '-' . $this->user_;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user_;
    }

    public function setUser(?User $user_): self
    {
        $this->user_ = $user_;

        return $this;
    }

    /**
     * @return Collection<int, BookByTazesId>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(BookByTazesId $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setBookLend($this);
        }

        return $this;
    }

    public function removeBook(BookByTazesId $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getBookLend() === $this) {
                $book->setBookLend(null);
            }
        }

        return $this;
    }

    public function getDateOfLend(): ?\DateTimeInterface
    {
        return $this->dateOfLend;
    }

    public function setDateOfLend(?\DateTimeInterface $dateOfLend): self
    {
        $this->dateOfLend = $dateOfLend;

        return $this;
    }
}
