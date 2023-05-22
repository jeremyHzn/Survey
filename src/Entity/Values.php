<?php

namespace App\Entity;

use App\Repository\ValuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValuesRepository::class)]
class Values
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $value = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Values::class)]
    private Collection $values;

    #[ORM\OneToMany(mappedBy: 'value', targetEntity: Questions::class)]
    private Collection $questions;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $parent = null;

    public function __construct()
    {
        $this->values = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Values>
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValue(Values $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
            $value->setParent($this);
        }

        return $this;
    }

    public function removeValue(Values $value): self
    {
        if ($this->values->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getParent() === $this) {
                $value->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
