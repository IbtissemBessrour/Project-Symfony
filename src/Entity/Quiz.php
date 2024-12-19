<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le titre du quiz ne peut pas être vide.")]
    #[Assert\Length(min: 5, max: 255, minMessage: "Le titre doit comporter au moins {{ limit }} caractères.")]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le score de passage ne peut pas être vide.")]
    #[Assert\Range(notInRangeMessage: "Le score de passage doit être entre {{ min }} et {{ max }}.", min: "1", max: "100")]
    private ?string $passingScore = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPassingScore(): ?string
    {
        return $this->passingScore;
    }

    public function setPassingScore(string $passingScore): static
    {
        $this->passingScore = $passingScore;

        return $this;
    }

}