<?php

namespace App\Entity;

use App\Repository\FormsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Console\Question\Question;

/**
 * class Forms.
 */
#[ORM\Entity(repositoryClass: FormsRepository::class)]
class Forms
{
    /**
     * @var int|null
     *               Id of forms
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var \DateTimeImmutable|null
     *                              Date of sended form
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $sendedAt = null;

    /**
     * @var string|null
     *                  Email of user
     */
    #[ORM\Column(length: 255)]
    private readonly ?string $email;

    /**
     * @var Questions|null
     *                     Question of form
     */
    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questions $question = null;

    /**
     * @var Collection<int, Reponses>
     *                                Collection of reponses
     */
    #[ORM\OneToMany(mappedBy: 'form', targetEntity: Reponses::class)]
    private Collection $reponses;

    /**
     * Constructor of Forms.
     */
    public function __construct(string $email, \DateTimeImmutable  $sendedAt = new \DateTimeImmutable())
    {
        $this->reponses = new ArrayCollection();
        $this->sendedAt = $sendedAt;
        $this->email = $email;
    }

    /**
     * Get id of forms.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get date of sended form.
     */
    public function getSendedAt(): ?\DateTimeImmutable
    {
        return $this->sendedAt;
    }

    /**
     * Set date of sended form.
     */
    public function setSendedAt(\DateTimeImmutable $sendedAt): self
    {
        $this->sendedAt = $sendedAt;

        return $this;
    }

    /**
     * Get email of user.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return self
     *              Set email of user
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Questions|null
     *                        Get question of form
     */
    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    /**
     * Set question of form.
     *
     * @return $this
     */
    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get collection of reponses.
     *
     * @return Collection<int, Reponses>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    /**
     * Add reponse to collection.
     */
    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setForm($this);
        }

        return $this;
    }

    /**
     * Remove reponse from collection.
     */
    public function removeReponse(Reponses $reponse): self
    {
        if ($this->reponses->removeElement($reponse) && $reponse->getForm() === $this) {
            // set the owning side to null (unless already changed)
            $reponse->setForm(null);
        }

        return $this;
    }
}
