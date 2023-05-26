<?php

namespace App\Entity;

use App\Repository\ReponsesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Reponses
 */
#[ORM\Entity(repositoryClass: ReponsesRepository::class)]
class Reponses
{
    /**
     * @var int|null
     * Id of reponses
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var \DateTimeImmutable|null
     * Date of submit
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $submitAt = null;

    /**
     * @var Forms|null
     * Form of reponses
     */
    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Forms $form = null;

    /**
     * Get id of reponses
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get date of submit
     */
    public function getSubmitAt(): ?\DateTimeImmutable
    {
        return $this->submitAt;
    }

    /**
     * Set date of submit
     */
    public function setSubmitAt(?\DateTimeImmutable $submitAt): self
    {
        $this->submitAt = $submitAt;

        return $this;
    }

    /**
     * Get form of reponses
     */
    public function getForm(): ?Forms
    {
        return $this->form;
    }

    /**
     * Set form of reponses
     */
    public function setForm(?Forms $form): self
    {
        $this->form = $form;

        return $this;
    }
}
