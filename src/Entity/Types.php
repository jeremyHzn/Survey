<?php

namespace App\Entity;

use App\Repository\TypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Types.
 */
#[ORM\Entity(repositoryClass: TypesRepository::class)]
class Types
{
    /**
     * @var int|null
     *               Id of the type
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string
     *             Type of the question
     */
    #[ORM\Column(length: 50)]
    #[ORM\JoinColumn(nullable: false)]
    private readonly string $type;

    /**
     * @var Collection<int, Questions>
     *                                 Collection of type questions
     */
    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Questions::class)]
    private Collection $questions;

    /**
     * Constructor of Types.
     */
    public function __construct(string $type)
    {
        $this->questions = new ArrayCollection();
        $this->type = $type;
    }

    /**
     * Get id of the type.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Questions>
     *                                    Get collection of type questions
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }
}
