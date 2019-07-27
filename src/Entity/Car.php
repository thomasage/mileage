<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Record", mappedBy="car", orphanRemoval=true)
     * @ORM\OrderBy({"date"="ASC"})
     */
    private $records;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $rentalStartedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rentalStartedMileage;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $rentalEndedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rentalEndedMileage;

    public function __construct()
    {
        $this->records = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string)$this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Record[]
     */
    public function getRecords(): Collection
    {
        return $this->records;
    }

    public function addRecord(Record $record): self
    {
        if (!$this->records->contains($record)) {
            $this->records[] = $record;
            $record->setCar($this);
        }

        return $this;
    }

    public function removeRecord(Record $record): self
    {
        if ($this->records->contains($record)) {
            $this->records->removeElement($record);
            // set the owning side to null (unless already changed)
            if ($record->getCar() === $this) {
                $record->setCar(null);
            }
        }

        return $this;
    }

    public function getRentalStartedAt(): ?\DateTimeInterface
    {
        return $this->rentalStartedAt;
    }

    public function setRentalStartedAt(?\DateTimeInterface $rentalStartedAt): self
    {
        $this->rentalStartedAt = $rentalStartedAt;

        return $this;
    }

    public function getRentalStartedMileage(): ?int
    {
        return $this->rentalStartedMileage;
    }

    public function setRentalStartedMileage(?int $rentalStartedMileage): self
    {
        $this->rentalStartedMileage = $rentalStartedMileage;

        return $this;
    }

    public function getRentalEndedAt(): ?\DateTimeInterface
    {
        return $this->rentalEndedAt;
    }

    public function setRentalEndedAt(?\DateTimeInterface $rentalEndedAt): self
    {
        $this->rentalEndedAt = $rentalEndedAt;

        return $this;
    }

    public function getRentalEndedMileage(): ?int
    {
        return $this->rentalEndedMileage;
    }

    public function setRentalEndedMileage(?int $rentalEndedMileage): self
    {
        $this->rentalEndedMileage = $rentalEndedMileage;

        return $this;
    }

    public function getSupposedMileageAt(?\DateTimeInterface $date = null): ?int
    {
        $duration = $this->getRentalDurationInDays();
        if (!$duration) {
            return null;
        }

        if (!$date) {
            $date = new \DateTime();
        }

        $daysFromStart = $date->diff($this->rentalStartedAt)->days;

        return (int)($daysFromStart * ($this->rentalEndedMileage - $this->rentalStartedMileage) / $duration);
    }

    public function getRentalDurationInDays(): ?int
    {
        if (!$this->rentalStartedAt || !$this->rentalEndedAt) {
            return null;
        }

        return $this->rentalEndedAt->diff($this->rentalStartedAt)->days;
    }
}
