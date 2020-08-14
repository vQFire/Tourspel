<?php

namespace App\Entity;

use App\Repository\VerslagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VerslagRepository::class)
 */
class Verslag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Etappe::class, inversedBy="verslagen")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Etappe;

    public function __construct()
    {
        $this->etappes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->Titel;
    }

    public function setTitel(string $Titel): self
    {
        $this->Titel = $Titel;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getEtappe(): ?Etappe
    {
        return $this->Etappe;
    }

    public function setEtappe(?Etappe $Etappe): self
    {
        $this->Etappe = $Etappe;

        return $this;
    }
}
