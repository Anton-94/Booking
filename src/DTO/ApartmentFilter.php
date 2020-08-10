<?php

namespace App\DTO;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ApartmentFilter
{
    private ?\DateTime $startDate;
    private ?\DateTime $endDate;
    private ?int $apartmentType;
    private ?int $guests;

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getApartmentType(): ?int
    {
        return $this->apartmentType;
    }

    public function setApartmentType(?int $apartmentType): void
    {
        $this->apartmentType = $apartmentType;
    }

    public function getGuests(): ?int
    {
        return $this->guests;
    }

    public function setGuests(?int $guests): void
    {
        $this->guests = $guests;
    }

    public function isStartBeforeEnd(ExecutionContextInterface $context): void
    {
        if ($this->getStartDate() >= $this->getEndDate()) {
            $context->buildViolation('The start date must be prior to the end date.')
                ->atPath('startDate')
                ->addViolation();
        }
    }
}