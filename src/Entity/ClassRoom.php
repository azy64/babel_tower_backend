<?php

namespace App\Entity;

use App\Repository\ClassRoomRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClassRoomRepository::class)
 */
class ClassRoom
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("tunaweza")
     */
    private $creationClass;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="classRooms")
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Lesson::class, mappedBy="classRoom", orphanRemoval=true)
     */
    private $lessons;

    /**
     * @ORM\OneToMany(targetEntity=Membership::class, mappedBy="classroom", orphanRemoval=true)
     * 
     */
    private $memberships;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->creationClass = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCreationClass(): ?\DateTimeInterface
    {
        return $this->creationClass;
    }

    public function setCreationClass(\DateTimeInterface $creationClass): self
    {
        $this->creationClass = $creationClass;

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
            $lesson->setClassRoom($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getClassRoom() === $this) {
                $lesson->setClassRoom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membership>
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function addMembership(Membership $membership): self
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships[] = $membership;
            $membership->setClassroom($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getClassroom() === $this) {
                $membership->setClassroom(null);
            }
        }

        return $this;
    }
}
