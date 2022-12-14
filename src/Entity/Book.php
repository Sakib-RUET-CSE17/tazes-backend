<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $writer = null;

    #[ORM\Column(nullable: true)]
    private ?int $edition = null;

    #[ORM\Column(nullable: true)]
    private ?int $totalQty = null;

    #[ORM\Column(nullable: true)]
    private ?int $availableQty = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: BookByTazesId::class)]
    private Collection $bookByTazesIds;

    public function __construct()
    {
        $this->bookLends = new ArrayCollection();
        $this->bookByTazesIds = new ArrayCollection();
    }

    public function __toString()
    {
        return 'book - ' . $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getWriter(): ?string
    {
        return $this->writer;
    }

    public function setWriter(?string $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function getEdition(): ?int
    {
        return $this->edition;
    }

    public function setEdition(?int $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    public function getTotalQty(): ?int
    {
        return $this->totalQty;
    }

    public function setTotalQty(?int $totalQty): self
    {
        $this->totalQty = $totalQty;

        return $this;
    }

    public function getAvailableQty(): ?int
    {
        return $this->availableQty;
    }

    public function setAvailableQty(?int $availableQty): self
    {
        $this->availableQty = $availableQty;

        return $this;
    }

    /**
     * @return Collection<int, BookByTazesId>
     */
    public function getBookByTazesIds(): Collection
    {
        return $this->bookByTazesIds;
    }

    public function addBookByTazesId(BookByTazesId $bookByTazesId): self
    {
        if (!$this->bookByTazesIds->contains($bookByTazesId)) {
            $this->bookByTazesIds->add($bookByTazesId);
            $bookByTazesId->setBook($this);
        }

        return $this;
    }

    public function removeBookByTazesId(BookByTazesId $bookByTazesId): self
    {
        if ($this->bookByTazesIds->removeElement($bookByTazesId)) {
            // set the owning side to null (unless already changed)
            if ($bookByTazesId->getBook() === $this) {
                $bookByTazesId->setBook(null);
            }
        }

        return $this;
    }
}
