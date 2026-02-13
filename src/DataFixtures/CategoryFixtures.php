<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $names = [
            'Tech',
            'Sport',
            'Cinéma',
            'Musique',
            'Gaming',
        ];

        foreach ($names as $i => $name) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription("Description de la catégorie $name.");
            $category->setCreatedBy($this->getReference(UserFixtures::ADMIN_REF, \App\Entity\User::class));


            $manager->persist($category);

            $this->addReference("cat_" . ($i + 1), $category);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
