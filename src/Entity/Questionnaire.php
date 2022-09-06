<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire
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
    private $titre;

    /**
     * @ORM\Column(type="date")
     * @groups("tunaweza")
     */
    private $dateCreation;

    /**
     * @ORM\OneToOne(targetEntity=Contenu::class, inversedBy="questionnaire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @groups("tunaweza")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="questionnaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="questionnaires")
     * @ORM\JoinColumn(nullable=false)
     * @groups("tunaweza")
     */
    private $question;

    public function __construct() {
        $this->dateCreation = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getContenu(): ?Contenu
    {
        return $this->contenu;
    }

    public function setContenu(Contenu $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLesson(): ?Lesson
    {
        return $this->lesson;
    }

    public function setLesson(?Lesson $lesson): self
    {
        $this->lesson = $lesson;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $questions): self
    {
        $this->question = $questions;

        return $this;
    }
}
