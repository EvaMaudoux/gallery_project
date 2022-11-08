<?php

namespace App\DataFixtures;

use App\Entity\Technical;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnicalFixtures extends Fixture
{
    private array $technicals = [
        'peinture à l\'huile',
        'aquarelle',
        'tempera',
        'peinture acrylique',
        'gouache',
        'encre',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach($this->technicals as $technical) {
            $tech = new Technical();
            $tech->setName($technical);
            $manager->persist($tech);
        }
        $manager->flush();
    }
}
