<?php

namespace App\Entity;

use App\Repository\FormsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormsRepository::class)]
class Forms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $sended_at = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Questions $question = null;

    #[ORM\OneToMany(mappedBy: 'form', targetEntity: Reponses::class)]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendedAt(): ?\DateTimeImmutable
    {
        return $this->sended_at;
    }

    public function setSendedAt(\DateTimeImmutable $sended_at): self
    {
        $this->sended_at = $sended_at;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getQuestion(): ?Questions
    {
        return $this->question;
    }

    public function setQuestion(?Questions $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, Reponses>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponses $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setForm($this);
        }

        return $this;
    }

    public function removeReponse(Reponses $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getForm() === $this) {
                $reponse->setForm(null);
            }
        }

        return $this;
    }
}
