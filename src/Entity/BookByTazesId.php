<?php

namespace App\Entity;

use App\Repository\BookByTazesIdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookByTazesIdRepository::class)]
class BookByTazesId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tazesCode = null;

    #[ORM\ManyToOne(inversedBy: 'bookByTazesIds')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?BookLend $bookLend = null;

    #[ORM\ManyToMany(targetEntity: BookReturn::class, mappedBy: 'books')]
    private Collection $bookReturns;

    public function __construct()
    {
        $this->bookReturns = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTazesCode(): ?string
    {
        return $this->tazesCode;
    }

    public function setTazesCode(?string $tazesCode): self
    {
        $this->tazesCode = $tazesCode;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBookLend(): ?BookLend
    {
        return $this->bookLend;
    }

    public function setBookLend(?BookLend $bookLend): self
    {
        $this->bookLend = $bookLend;

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
            $bookReturn->addBook($this);
        }

        return $this;
    }

    public function removeBookReturn(BookReturn $bookReturn): self
    {
        if ($this->bookReturns->removeElement($bookReturn)) {
            $bookReturn->removeBook($this);
        }

        return $this;
    }
}
