<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
     * @ORM\Column(type="string", length=255)
     */
    private $reponse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $assertion1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assertion2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $assertion3;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="questions", orphanRemoval=true)
     */
    private $questionnaires;

    public function __construct()
    {
        $this->questionnaires = new ArrayCollection();
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

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getAssertion1(): ?string
    {
        return $this->assertion1;
    }

    public function setAssertion1(string $assertion1): self
    {
        $this->assertion1 = $assertion1;

        return $this;
    }

    public function getAssertion2(): ?string
    {
        return $this->assertion2;
    }

    public function setAssertion2(?string $assertion2): self
    {
        $this->assertion2 = $assertion2;

        return $this;
    }

    public function getAssertion3(): ?string
    {
        return $this->assertion3;
    }

    public function setAssertion3(?string $assertion3): self
    {
        $this->assertion3 = $assertion3;

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
            $questionnaire->setQuestion($this);
        }

        return $this;
    }

    public function removeQuestionnaire(Questionnaire $questionnaire): self
    {
        if ($this->questionnaires->removeElement($questionnaire)) {
            // set the owning side to null (unless already changed)
            if ($questionnaire->getQuestion() === $this) {
                $questionnaire->setQuestion(null);
            }
        }

        return $this;
    }

}
