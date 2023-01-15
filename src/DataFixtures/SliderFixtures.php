<?php

namespace App\DataFixtures;

use App\Entity\Slider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SliderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=1; $i <= 5 ; $i++) {
            $slider = new Slider();
            $slider->setImageName($i .'.jpg')
                    ->setUpdatedAt(new \DateTimeImmutable)
                    ->setIsSelected($faker->boolean(80));

            $manager->persist($slider);
        }

        $manager->flush();
    }
}
