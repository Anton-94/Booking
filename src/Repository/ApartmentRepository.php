<?php

namespace App\Repository;

use App\DTO\ApartmentFilter;
use App\Entity\Apartment;
use App\Enum\ApartmentEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Apartment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Apartment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Apartment[]    findAll()
 * @method Apartment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apartment::class);
    }

    public function findApartmentsByParams(ApartmentFilter $searchApartment): array
    {
        $qb = $this->_em->getConnection()->createQueryBuilder();

        $qb
            ->select([
                'a.id',
                'a.name',
                'a.price',
                'a.slots',
            ])
            ->from('apartment', 'a')
            ->leftJoin('a', '(
                SELECT r.*, sum(r.guests) as sumGuests
                FROM reservation AS r 
                WHERE r.start_date < :endDate AND r.end_date > :startDate
                GROUP BY r.apartment_id
            )', 'r', 'r.apartment_id = a.id')
            ->where($qb->expr()->gt('a.slots', 'COALESCE(r.sumGuests, 0)'))
            ->setParameter('startDate', $searchApartment->getStartDate()->format('Y-m-d'))
            ->setParameter('endDate', $searchApartment->getStartDate()->format('Y-m-d'))
        ;

        if(ApartmentEnum::isFlat($searchApartment->getApartmentType())) {
            $qb
                ->andWhere($qb->expr()->gte('a.slots - COALESCE(r.sumGuests, 0)', 'a.slots'));
        } else {
            $qb
                ->andWhere($qb->expr()->gte('a.slots - COALESCE(r.sumGuests, 0)', ':guests'))
                ->setParameter('guests', $searchApartment->getApartmentType() == ApartmentEnum::FLAT ? 'a.slots' : $searchApartment->getGuests())
            ;
        }

        $stmt = $qb->execute();
        return $stmt->fetchAll();
    }
}
