<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecordRepository")
 */
class Record
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car", inversedBy="records")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    private $car;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Range(min=0)
     */
    private $value;

    /**
     * @ORM\Column(type="boolean")
     */
    private $forecast = false;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getForecast(): bool
    {
        return $this->forecast;
    }

    public function setForecast(bool $forecast): self
    {
        $this->forecast = $forecast;

        return $this;
    }
}
