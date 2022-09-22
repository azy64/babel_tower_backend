<?php

namespace App\Entity;

use App\Repository\ContenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ContenuRepository::class)
 */
class Contenu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("tunaweza")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("tunaweza")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("tunaweza")
     */
    private $fileName;

    /**
     * @ORM\ManyToOne(targetEntity=TypeContenu::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups("tunaweza")
     */
    private $typeContenu;

    /**
     * @ORM\ManyToMany(targetEntity=Lesson::class, inversedBy="contenus")
     */
    private $lessons;

    /**
     * @ORM\OneToMany(targetEntity=Modality::class, mappedBy="contenu", orphanRemoval=true)
     * @Groups("tunaweza")
     */
    private $modalities;

    /**
     * @ORM\OneToOne(targetEntity=Questionnaire::class, mappedBy="contenu", cascade={"persist", "remove"})
     */
    private $questionnaire;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
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

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getTypeContenu(): ?TypeContenu
    {
        return $this->typeContenu;
    }

    public function setTypeContenu(?TypeContenu $typeContenu): self
    {
        $this->typeContenu = $typeContenu;

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        $this->lessons->removeElement($lesson);

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
            $modality->setContenu($this);
        }

        return $this;
    }

    public function removeModality(Modality $modality): self
    {
        if ($this->modalities->removeElement($modality)) {
            // set the owning side to null (unless already changed)
            if ($modality->getContenu() === $this) {
                $modality->setContenu(null);
            }
        }

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(Questionnaire $questionnaire): self
    {
        // set the owning side of the relation if necessary
        if ($questionnaire->getContenu() !== $this) {
            $questionnaire->setContenu($this);
        }

        $this->questionnaire = $questionnaire;

        return $this;
    }
}
