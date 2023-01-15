<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Painting;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
       public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $painting = $manager->getRepository(Painting::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for($i = 1; $i <= 60 ; $i++)
        {
            $comment = new Comment();
            $title = $faker->words(2, true);
            $comment->setTitle($title)
                    ->setContent($faker->paragraphs(1, true))
                    ->setPainting($painting[$faker->numberBetween(0,count($painting)-1)])
                    ->setUser($users [$faker->numberBetween(0, (count($users) -1))]);

            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TechnicalFixtures::class,
            PaintingFixtures::class
        ];
    }
}
