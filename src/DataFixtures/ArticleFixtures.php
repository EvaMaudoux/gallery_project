<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();


        for($i = 1; $i <= 30 ; $i++) {
            $date = $faker->dateTimeBetween('-10 year', 'now');
            $article = new Article();
            $article -> setName($faker->words(3, true))
                    ->setDescription($faker->paragraph(2, true))
                    ->setContent($faker->paragraphs(2, true))
                    ->setCreatedAt(new \DateTimeImmutable(date_format($date, "d-m-Y")))
                    ->setImageName($i . '.jpg')
                    ->setIsPublished($faker->boolean(80))
                    ->setSlug($slugify->slugify($article->getName()));

            $manager->persist($article);
        }

        $manager->flush();
    }
}
