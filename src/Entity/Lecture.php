<?php

namespace App\Entity;

use App\Repository\LectureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LectureRepository::class)
 */
class Lecture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $speed;

    /**
     * @ORM\Column(type="integer")
     */
    private $repetition;

    /**
     * @ORM\OneToMany(targetEntity=Modality::class, mappedBy="lecture", orphanRemoval=true)
     */
    private $modalities;

    public function __construct()
    {
        $this->modalities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(int $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    /**
     * @return Collection<int, Modality>
     */
    public function getModalities(): Collection
    {
        return $this->modalities;
    }

    public function addModality(Modality $modality): self
    {
        if (!$this->modalities->contains($modality)) {
            $this->modalities[] = $modality;
            $modality->setLecture($this);
        }

        return $this;
    }

    public function removeModality(Modality $modality): self
    {
        if ($this->modalities->removeElement($modality)) {
            // set the owning side to null (unless already changed)
            if ($modality->getLecture() === $this) {
                $modality->setLecture(null);
            }
        }

        return $this;
    }
}
