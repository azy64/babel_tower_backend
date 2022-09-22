<?php

namespace App\Entity;

use App\Repository\ModalityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ModalityRepository::class)
 */
class Modality
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("tunaweza")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Lesson::class, inversedBy="modalities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson;

    /**
     * @ORM\ManyToOne(targetEntity=Contenu::class, inversedBy="modalities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Lecture::class, inversedBy="modalities")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("tunaweza")
     */
    private $lecture;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContenu(): ?Contenu
    {
        return $this->contenu;
    }

    public function setContenu(?Contenu $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLecture(): ?Lecture
    {
        return $this->lecture;
    }

    public function setLecture(?Lecture $lecture): self
    {
        $this->lecture = $lecture;

        return $this;
    }
}
