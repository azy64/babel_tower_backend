<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups("tunaweza")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @groups("tunaweza")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @groups("tunaweza")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups("tunaweza")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @groups("tunaweza")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Membership::class, mappedBy="student", orphanRemoval=true)
     * @groups("tunaweza")
     */
    private $memberships;

    /**
     * @ORM\OneToMany(targetEntity=Resolution::class, mappedBy="student", orphanRemoval=true)
     * @groups("tunaweza")
     */
    private $resolutions;

    public function __construct()
    {
        $this->memberships = new ArrayCollection();
        $this->resolutions = new ArrayCollection();
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
            $membership->setStudent($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getStudent() === $this) {
                $membership->setStudent(null);
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
            $resolution->setStudent($this);
        }

        return $this;
    }

    public function removeResolution(Resolution $resolution): self
    {
        if ($this->resolutions->removeElement($resolution)) {
            // set the owning side to null (unless already changed)
            if ($resolution->getStudent() === $this) {
                $resolution->setStudent(null);
            }
        }

        return $this;
    }
}
