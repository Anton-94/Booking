<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @ORM\Table(name="reservation")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Apartment::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private Apartment $apartment;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $endDate;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private int $guests;

    /**
     * @ORM\Column(type="float")
     */
    private float $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApartment(): ?Apartment
    {
        return $this->apartment;
    }

    public function setApartment(Apartment $apartment): void
    {
        $this->apartment = $apartment;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(int $guests): void
    {
        $this->guests = $guests;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
