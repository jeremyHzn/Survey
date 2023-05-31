<?php

namespace App\Entity;

use App\Repository\QuestionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Questions.
 */
#[ORM\Entity(repositoryClass: QuestionsRepository::class)]
class Questions
{
    /**
     * @var int|null
     *               Id of the question
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string
     *             Category of the question
     */

    /**
     * @var string|null
     *                  Subject of the question
     */
    #[ORM\Column(length: 255, nullable: true)]
    private string $subject;

    /**
     * @var \DateTimeImmutable
     *                         Date of creation of the question
     */
    #[ORM\Column]
    public readonly \DateTimeImmutable $createdAt;

    /**
     * @var \DateTimeImmutable|null
     *                              Date of modification of the question
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    /**
     * @var Questions|null
     *                     Parent of the question
     */
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?self $parent;

    /**
     * @var Collection|ArrayCollection
     *                                 Collection of questions
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $questions;

    /**
     * @var Types
     *            Type of the question
     */
    #[ORM\ManyToOne(inversedBy: 'questions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    public readonly Types $type;

    /**
     * @var Values
     *             Value of the question
     */
    #[ORM\ManyToOne(inversedBy: 'questions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    public readonly Values $value;

    /**
     * @var Collection|ArrayCollection
     *                                 Collection of forms
     */
    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Forms::class)]
    private Collection $forms;

    /**
     * constructor of the question.
     */
    public function __construct($createdAt = new \DateTimeImmutable())
    {
        $this->questions = new ArrayCollection();
        $this->forms = new ArrayCollection();

        $this->createdAt = $createdAt;

    }

    /**
     * @return int|null
     *                  Return the id of the question
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     * Return the subject of the question
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return $this
     *               Set the subject of the question
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     *                                 Return the date of creation of the question
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeImmutable|null
     *                                 Return the date of modification of the question
     */
    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    /**
     * @return $this
     *               Set the date of modification of the question
     */
    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): self
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * @return Questions|null
     *                        Return the parent of the question
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @return $this
     *               Set the parent of the question
     */
    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     *                               Return the collection of questions
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * @return $this
     *               Add a question to the collection of questions
     */
    public function addQuestion(self $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setParent($this);
        }

        return $this;
    }

    /**
     * @return $this
     *               Remove a question from the collection of questions
     */
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
     *                                Return the collection of forms
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    /**
     * @return $this
     *               Add a form to the collection of forms
     */
    public function addForm(Forms $form): self
    {
        if (!$this->forms->contains($form)) {
            $this->forms->add($form);
            $form->setQuestion($this);
        }

        return $this;
    }

    /**
     * @return $this
     *               Remove a form from the collection of forms
     */
    public function removeForm(Forms $form): self
    {
        if ($this->forms->removeElement($form) && $form->getQuestion() === $this) {
            // set the owning side to null (unless already changed)
            $form->setQuestion(null);
        }

        return $this;
    }
}
