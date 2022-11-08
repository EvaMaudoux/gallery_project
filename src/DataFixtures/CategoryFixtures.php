<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private array $categories = [
        'le baroque',
        'le romantisme',
        'l\'impressionnisme',
        'le fauvisme',
        'l\'expressionnisme',
        'le surréalisme',
        'le pop art',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach($this->categories as $category) {
            $cat = new Category();
            $cat->setName($category);
            $manager->persist($cat);
        }
        $manager->flush();
    }
}
