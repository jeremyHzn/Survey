<?php

namespace App\Entity;

use App\Repository\ValuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValuesRepository::class)]
class Values
{
    /**
     * @var int|null
     * Id of the value
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     * Value of the value
     */
    #[ORM\Column(length: 50)]
    private ?string $value;

    /**
     * @var Collection|ArrayCollection
     * Collection of values of the value
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Values::class)]
    private Collection $values;

    /**
     * @var Collection|ArrayCollection
     * Collection of questions of the value
     */
    #[ORM\OneToMany(mappedBy: 'value', targetEntity: Questions::class)]
    private Collection $questions;

    /**
     * @var Values|null
     * Parent of the value
     */
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private ?self $parent = null;

    /**
     * Constructor of Values
     */
    public function __construct()
    {
        $this->values = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    /**
     * Get id of the value
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get value of the value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set value of the value
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Values>
     * Get collection of values of the value
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    /**
     * @param Values $value
     * @return $this
     * Add value to the collection of values of the value
     */
    public function addValue(Values $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
            $value->setParent($this);
        }
        return $this;
    }

    /**
     * @param Values $value
     * @return $this
     * Remove value from the collection of values of the value
     */
    public function removeValue(Values $value): self
    {
        if ($this->values->removeElement($value) && $value->getParent() === $this) {
            // set the owning side to null (unless already changed)
            $value->setParent(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Questions>
     * Get collection of questions of the value
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @return self|null
     * Get parent of the value
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param Values|null $parent
     * @return $this
     * Set parent of the value
     */
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
