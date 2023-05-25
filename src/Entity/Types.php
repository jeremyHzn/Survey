<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesRepository::class)]
class Types
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[ORM\JoinColumn(nullable: false)]
    private readonly string $type;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Questions::class)]
    private Collection $questions;

    public function __construct(string $type)
    {
        $this->questions = new ArrayCollection();
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }
}
