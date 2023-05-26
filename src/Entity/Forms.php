<?php

namespace App\Entity;

use App\Repository\FormsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Forms
 */
#[ORM\Entity(repositoryClass: FormsRepository::class)]
class Forms
{
    /**
     * @var int|null
     * Id of forms
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var \DateTimeImmutable|null
     * Date of sended form
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $sendedAt = null;

    /**
     * @var string|null
     * Email of user
     */
    #[ORM\Column(length: 255)]
    private readonly ?string $email;

    /**
     * @var Questions|null
     * Question of form
     */
    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questions $question = null;

    /**
     * @var Collection<int, Reponses>
     * Collection of reponses
     */
    #[ORM\OneToMany(mappedBy: 'form', targetEntity: Reponses::class)]
    private Collection $reponses;

    /**
     * Constructor of Forms
     */
    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    /**
     * Get id of forms
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get date of sended form
     * @return \DateTimeImmutable|null
     */
    public function getSendedAt(): ?\DateTimeImmutable
    {
        return $this->sendedAt;
    }

    /**
     * Set date of sended form
     * @param \DateTimeImmutable $sendedAt
     * @return self
     */
    public function setSendedAt(\DateTimeImmutable $sendedAt): self
    {
        $this->sendedAt = $sendedAt;

        return $this;
    }

    /**
     * Get email of user
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     * Set email of user
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Questions|null
     * Get question of form
     */
    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    /**
     * Set question of form
     * @param Questions|null $question
     * @return $this
     */
    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get collection of reponses
     * @return Collection<int, Reponses>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    /**
     * Add reponse to collection
     * @param Reponses $reponse
     * @return self
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
     * Remove reponse from collection
     * @param Reponses $reponse
     * @return self
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
