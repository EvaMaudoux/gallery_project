<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Painting;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArtistFixtures extends Fixture
{
    private array $genders = ['male', 'female'];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        for($i = 1; $i <= 30; $i++) {

            $artist = new Artist();
            $birthDate = $faker->dateTimeBetween('-400 year', '-200 year');
            $gender = $faker->randomElement($this->genders);

            $artist ->setFirstName($faker->firstName($gender))
                    ->setLastName($faker->lastName)
                    -> setBirthDate(new \DateTimeImmutable(date_format($birthDate, "d-m-Y")))
                    -> setBiography($faker->paragraphs(3,true));
            $gender = $gender == 'male' ? 'm' : 'f';
            $artist -> setImageName($i . $gender . '.jpg')
                    -> setSlug($slugify->slugify($artist->getLastName()));

            $manager -> persist($artist);
        }
        $manager->flush();
    }
}
