<?php

namespace App\DataFixtures;

use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private object $hasher;
    private array $genders = ['male', 'female'];

    public function __construct(UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $slug = new Slugify(); // uniquement pour nettoyer le prefixe du mail

        for($i = 1; $i <= 50; $i++) {
            $user = new User();
            $gender = $faker->randomElement($this->genders);
            $user   ->setFirstName($faker->firstName($gender))
                    ->setLastName($faker->lastName)
                    ->setEmail($slug->slugify($user->getFirstName()) . '.' . $slug->slugify($user->getLastName()) . '@' . $faker->freeEmailDomain());
            $gender = $gender == 'male' ? 'm' : 'f';
            $user   ->setImageName($i . $gender . '.jpg')
                    ->setPassword($this->hasher->hashPassword($user, 'password'))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                    ->setIsDisabled($faker->boolean(10))
                    ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        // Admin Eva Maudoux
        $user = new User();
        $user   ->setFirstName('Eva')
            ->setLastName('Maudoux')
            ->setEmail('eva.maudoux@gmail.com')
            ->setImageName('25f.jpg')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setIsDisabled(false)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();


        // Super_Admin Pat Mar
        $user = new User();
        $user   ->setFirstName('Pat')
            ->setLastName('Mar')
            ->setEmail('patmar@gmail.com')
            ->setImageName('patmar.jpg')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setIsDisabled(false)
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}
