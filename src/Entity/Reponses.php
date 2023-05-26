<?php

namespace App\Entity;

use App\Repository\ReponsesRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ReponsesRepository::class)]
class Reponses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $submitAt = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Forms $form = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmitAt(): ?\DateTimeImmutable
    {
        return $this->submitAt;
    }

    public function setSubmitAt(?\DateTimeImmutable $submitAt): self
    {
        $this->submitAt = $submitAt;

        return $this;
    }

    public function getForm(): ?Forms
    {
        return $this->form;
    }

    public function setForm(?Forms $form): self
    {
        $this->form = $form;

        return $this;
    }
}
