<?php

namespace App\Entity;


use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $category;

    #[ORM\Column(length: 255, nullable: true)]
    private string $subject;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?self $parent;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $questions;

    #[ORM\ManyToOne(inversedBy: 'questions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    public readonly Types $type ;

    #[ORM\ManyToOne(inversedBy: 'questions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    public readonly Values $value;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Forms::class)]
    private Collection $forms;

    public function __construct(Types $type, Values $value)
    {
        $this->questions = new ArrayCollection();
        $this->forms = new ArrayCollection();
        $this->type = $type;
        $this->value = $value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
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

    /**
     * @return Collection<int, self>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(self $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setParent($this);
        }

        return $this;
    }

    public function removeQuestion(self $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getParent() === $this) {
                $question->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Forms>
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    public function addForm(Forms $form): self
    {
        if (!$this->forms->contains($form)) {
            $this->forms->add($form);
            $form->setQuestion($this);
        }

        return $this;
    }

    public function removeForm(Forms $form): self
    {
        if ($this->forms->removeElement($form)) {
            // set the owning side to null (unless already changed)
            if ($form->getQuestion() === $this) {
                $form->setQuestion(null);
            }
        }

        return $this;
    }
}
