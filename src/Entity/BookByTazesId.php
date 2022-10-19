<?php

namespace App\Entity;

use App\Repository\BookByTazesIdRepository;
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
}
