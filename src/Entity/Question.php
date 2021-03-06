<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $problem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fails;

    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Familly", inversedBy="quizzes", cascade={"persist"})
     * @ORM\OrderBy( { "id" = "DESC" } )
     */
    private $familly;

    public function __toString() {
        return $this->name;
    }

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getFamilly(): ?Familly
    {
        return $this->familly;
    }

    public function setFamilly(?Familly $familly): self
    {
        $this->familly = $familly;

        return $this;
    }

    public function getProblem(): ?bool
    {
        return $this->problem;
    }

    public function setProblem(?bool $problem): self
    {
        $this->problem = $problem;

        return $this;
    }

    public function getFails(): ?int
    {
        return $this->fails;
    }

    public function setFails(?int $fails): self
    {
        $this->fails = $fails;

        return $this;
    }
}
