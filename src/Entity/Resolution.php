<?php

namespace App\Entity;

use App\Repository\ResolutionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ResolutionRepository::class)
 */
class Resolution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups("tunaweza")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @groups("tunaweza")
     */
    private $dateDebutResolution;

    /**
     * @ORM\Column(type="datetime")
     * @groups("tunaweza")
     */
    private $dateFinResolution;

    /**
     * @ORM\Column(type="datetime")
     * @groups("tunaweza")
     */
    private $dateResolution;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups("tunaweza")
     */
    private $libelleResponse;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="resolutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\OneToOne(targetEntity=Question::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @groups("tunaweza")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="resolutions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutResolution(): ?\DateTimeInterface
    {
        return $this->dateDebutResolution;
    }

    public function setDateDebutResolution(\DateTimeInterface $dateDebutResolution): self
    {
        $this->dateDebutResolution = $dateDebutResolution;

        return $this;
    }

    public function getDateFinResolution(): ?\DateTimeInterface
    {
        return $this->dateFinResolution;
    }

    public function setDateFinResolution(\DateTimeInterface $dateFinResolution): self
    {
        $this->dateFinResolution = $dateFinResolution;

        return $this;
    }

    public function getDateResolution(): ?\DateTimeInterface
    {
        return $this->dateResolution;
    }

    public function setDateResolution(\DateTimeInterface $dateResolution): self
    {
        $this->dateResolution = $dateResolution;

        return $this;
    }

    public function getLibelleResponse(): ?string
    {
        return $this->libelleResponse;
    }

    public function setLibelleResponse(string $libelleResponse): self
    {
        $this->libelleResponse = $libelleResponse;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

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
}
