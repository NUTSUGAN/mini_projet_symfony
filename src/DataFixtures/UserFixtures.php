<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_REF = 'user_admin';

    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        // ADMIN
        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'qwerty'));
        $manager->persist($admin);

        $this->addReference(self::ADMIN_REF, $admin);

        // USERS
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("user$i@gmail.com");
            $user->setFirstName("User$i");
            $user->setLastName("Test$i");
            $user->setRoles([]); // ROLE_USER par défaut
            $user->setPassword($this->hasher->hashPassword($user, 'qwerty'));
            $manager->persist($user);

            $this->addReference("user_$i", $user);
        }

        $manager->flush();
    }
}
