<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("personID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("personID")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("personID")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("personID")
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("personID")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("personID")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Lesson::class, mappedBy="teacher", orphanRemoval=true)
     */
    private $lessons;

    /**
     * @ORM\OneToMany(targetEntity=ClassRoom::class, mappedBy="teacher")
     */
    private $classRooms;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="teacher")
     * @Groups("personID")
     */
    private $students;


    /**
     * @ORM\OneToMany(targetEntity=Membership::class, mappedBy="teacher", orphanRemoval=true)
     */
    private $memberships;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->classRooms = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->students = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
            $lesson->setTeacher($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getTeacher() === $this) {
                $lesson->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClassRoom>
     */
    public function getClassRooms(): Collection
    {
        return $this->classRooms;
    }

    public function addClassRoom(ClassRoom $classRoom): self
    {
        if (!$this->classRooms->contains($classRoom)) {
            $this->classRooms[] = $classRoom;
            $classRoom->setTeacher($this);
        }

        return $this;
    }

    public function removeClassRoom(ClassRoom $classRoom): self
    {
        if ($this->classRooms->removeElement($classRoom)) {
            // set the owning side to null (unless already changed)
            if ($classRoom->getTeacher() === $this) {
                $classRoom->setTeacher(null);
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
            $membership->setTeacher($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getTeacher() === $this) {
                $membership->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setTeacher($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getTeacher() === $this) {
                $student->setTeacher(null);
            }
        }

        return $this;
    }

}
