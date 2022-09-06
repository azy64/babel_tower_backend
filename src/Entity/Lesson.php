<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups("tunaweza")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups("tunaweza")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups("tunaweza")
     */
    private $consigneOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @groups("tunaweza")
     */
    private $consigneTwo;

    /**
     * @ORM\Column(type="datetime")
     * @groups("tunaweza")
     */
    private $dateLesson;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     * @groups("tunaweza")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity=ClassRoom::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=true)
     * @groups("tunaweza")
     */
    private $classRoom;

    /**
     * @ORM\ManyToMany(targetEntity=Contenu::class, mappedBy="lessons")
     * @groups("tunaweza")
     */
    private $contenus;

    /**
     * @ORM\OneToMany(targetEntity=Modality::class, mappedBy="lesson", orphanRemoval=true)
     * @groups("tunaweza")
     */
    private $modalities;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="lesson", orphanRemoval=true)
     * @groups("tunaweza")
     */
    private $questionnaires;

    /**
     * @ORM\OneToMany(targetEntity=Resolution::class, mappedBy="lesson", orphanRemoval=true)
     * @groups("tunaweza")
     */
    private $resolutions;

    public function __construct()
    {
        $this->contenus = new ArrayCollection();
        $this->modalities = new ArrayCollection();
        $this->questionnaires = new ArrayCollection();
        $this->resolutions = new ArrayCollection();
        $this->dateLesson = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getConsigneOne(): ?string
    {
        return $this->consigneOne;
    }

    public function setConsigneOne(string $consigneOne): self
    {
        $this->consigneOne = $consigneOne;

        return $this;
    }

    public function getConsigneTwo(): ?string
    {
        return $this->consigneTwo;
    }

    public function setConsigneTwo(?string $consigneTwo): self
    {
        $this->consigneTwo = $consigneTwo;

        return $this;
    }

    public function getDateLesson(): ?\DateTimeInterface
    {
        return $this->dateLesson;
    }

    public function setDateLesson(\DateTimeInterface $dateLesson): self
    {
        $this->dateLesson = $dateLesson;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getClassRoom(): ?ClassRoom
    {
        return $this->classRoom;
    }

    public function setClassRoom(?ClassRoom $classRoom): self
    {
        $this->classRoom = $classRoom;

        return $this;
    }

    /**
     * @return Collection<int, Contenu>
     */
    public function getContenus(): Collection
    {
        return $this->contenus;
    }

    public function addContenu(Contenu $contenu): self
    {
        if (!$this->contenus->contains($contenu)) {
            $this->contenus[] = $contenu;
            $contenu->addLesson($this);
        }

        return $this;
    }

    public function removeContenu(Contenu $contenu): self
    {
        if ($this->contenus->removeElement($contenu)) {
            $contenu->removeLesson($this);
        }

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
            $modality->setLesson($this);
        }

        return $this;
    }

    public function removeModality(Modality $modality): self
    {
        if ($this->modalities->removeElement($modality)) {
            // set the owning side to null (unless already changed)
            if ($modality->getLesson() === $this) {
                $modality->setLesson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Questionnaire>
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }

    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        if (!$this->questionnaires->contains($questionnaire)) {
            $this->questionnaires[] = $questionnaire;
            $questionnaire->setLesson($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getLesson() === $this) {
                $questionnaire->setLesson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Resolution>
     */
    public function getResolutions(): Collection
    {
        return $this->resolutions;
    }

    public function addResolution(Resolution $resolution): self
    {
        if (!$this->resolutions->contains($resolution)) {
            $this->resolutions[] = $resolution;
            $resolution->setLesson($this);
        }

        return $this;
    }

    public function removeResolution(Resolution $resolution): self
    {
        if ($this->resolutions->removeElement($resolution)) {
            // set the owning side to null (unless already changed)
            if ($resolution->getLesson() === $this) {
                $resolution->setLesson(null);
            }
        }

        return $this;
    }
}
