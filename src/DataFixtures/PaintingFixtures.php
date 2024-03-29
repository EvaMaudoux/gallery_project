<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Category;
use App\Entity\Painting;
use App\Entity\PaintingLike;
use App\Entity\Technical;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PaintingFixtures extends Fixture implements DependentFixtureInterface
{
    private array $heights = [ 60, 80, 100, 150, 180, 200, 250, 300 ];
    private array $widths = [80, 100, 150, 180, 200, 250, 300, 350, 400];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $technicals = $manager->getRepository(Technical::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();
        $artists = $manager->getRepository(Artist::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $slugify = new Slugify();

        $nbHeight= count($this->heights);
        $nbWidth = count($this->widths);

        for($i=1; $i <= 50 ; $i++)
        {
            $painting = new Painting();
            $title = $faker->words(2, true);
            $date = $faker->dateTimeBetween('-400 year', 'now');
            $painting   ->setTitle($title)
                        ->setSmallDescription($faker->words(7,true) . '.')
                        ->setFullDescription($faker->paragraphs(3,true))
                        ->setCreated(new \DateTimeImmutable(date_format($date, "d-m-Y")))
                        ->setHeight($this->heights[$faker->numberBetween(0, $nbHeight - 1)])
                        ->setWidth($this->widths[$faker->numberBetween(0, $nbWidth - 1)])
                        ->setImageName($i .'.jpg')
                        ->setPrice($faker->numberBetween(500, 10000))
                        ->setIsSold($faker->boolean(10))
                        ->setTechnical($technicals [$faker->numberBetween(0, (count($technicals) - 1))])
                        ->setCategory($categories [$faker->numberBetween(0, (count($categories) - 1))])
                        ->setArtist($artists [$faker->numberBetween(0, (count($artists) - 1))])
                        ->setSlug($slugify->slugify($title));
            $manager->persist($painting);

            for( $j = 1; $j < mt_rand(0, 15); $j++) {
                $like = new PaintingLike();
                $like ->setPainting($painting)
                      ->setUser($users [$faker->numberBetween(0, (count($users) -1))]);
                $manager->persist($like);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TechnicalFixtures::class,
            ArtistFixtures::class,
            ];
    }
}
