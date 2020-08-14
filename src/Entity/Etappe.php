<?php

namespace App\Entity;

use App\Repository\EtappeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtappeRepository::class)
 */
class Etappe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Stage;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $Type;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Start;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $Finish;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Distance;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Renner;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $Deelnemer;

    /**
     * @ORM\OneToMany(targetEntity=Verslag::class, mappedBy="Etappe")
     */
    private $verslagen;

    public function __construct()
    {
        $this->verslagen = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStage(): ?int
    {
        return $this->Stage;
    }

    public function setStage(int $Stage): self
    {
        $this->Stage = $Stage;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getStart(): ?string
    {
        return $this->Start;
    }

    public function setStart(?string $Start): self
    {
        $this->Start = $Start;

        return $this;
    }

    public function getFinish(): ?string
    {
        return $this->Finish;
    }

    public function setFinish(?string $Finish): self
    {
        $this->Finish = $Finish;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->Distance;
    }

    public function setDistance(?int $Distance): self
    {
        $this->Distance = $Distance;

        return $this;
    }

    public function getRenner(): ?string
    {
        return $this->Renner;
    }

    public function setRenner(?string $Renner): self
    {
        $this->Renner = $Renner;

        return $this;
    }

    public function getDeelnemer(): ?string
    {
        return $this->Deelnemer;
    }

    public function setDeelnemer(?string $Deelnemer): self
    {
        $this->Deelnemer = $Deelnemer;

        return $this;
    }

    public function getTansDate(): ?string
    {
        $date = $this->getDate();
        $day = $date->format('w');
        $dayMonth = $date->format('j');
        $month = $date->format('n');

        switch ($month) {
            case 1: $month = "januari"; break;
            case 2: $month = "februari"; break;
            case 3: $month = "maart"; break;
            case 4: $month = "april"; break;
            case 5: $month = "mei"; break;
            case 6: $month = "juni"; break;
            case 7: $month = "julie"; break;
            case 8: $month = "augustus"; break;
            case 9: $month = "septemper"; break;
            case 10: $month = "oktober"; break;
            case 11: $month = "november"; break;
            case 12: $month = "december"; break;
        }

        switch ($day) {
            case 0: $day = "Zondag"; break;
            case 1: $day = "Maandag"; break;
            case 2: $day = "Dinsdag"; break;
            case 3: $day = "Woensdag"; break;
            case 4: $day = "Donderdag"; break;
            case 5: $day = "Vrijdag"; break;
            case 6: $day = "Zaterdag"; break;
        }

        return "$day, $dayMonth $month";
    }

    /**
     * @return Collection|Verslag[]
     */
    public function getVerslagen(): Collection
    {
        return $this->verslagen;
    }

    public function addVerslagen(Verslag $verslagen): self
    {
        if (!$this->verslagen->contains($verslagen)) {
            $this->verslagen[] = $verslagen;
            $verslagen->setEtappe($this);
        }

        return $this;
    }

    public function removeVerslagen(Verslag $verslagen): self
    {
        if ($this->verslagen->contains($verslagen)) {
            $this->verslagen->removeElement($verslagen);
            // set the owning side to null (unless already changed)
            if ($verslagen->getEtappe() === $this) {
                $verslagen->setEtappe(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return strval($this->getStage() . " - " . $this->getStart());
    }
}
