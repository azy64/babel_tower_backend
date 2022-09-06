<?php
/**
 * cette classe correspond à la table appartenace du model conceptuel
 */
namespace App\Entity;

use App\Repository\MembershipRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MembershipRepository::class)
 */
class Membership
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
    private $dateMembership;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="memberships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="memberships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity=ClassRoom::class, inversedBy="memberships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classroom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMembership(): ?\DateTimeInterface
    {
        return $this->dateMembership;
    }

    public function setDateMembership(\DateTimeInterface $dateMembership): self
    {
        $this->dateMembership = $dateMembership;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getClassroom(): ?ClassRoom
    {
        return $this->classroom;
    }

    public function setClassroom(?ClassRoom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }
}
