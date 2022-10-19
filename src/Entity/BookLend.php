<?php

namespace App\Entity;

use App\Repository\BookLendRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookLendRepository::class)]
class BookLend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __toString()
    {
        return 'lend - ' . $this->user_;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
