<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $post = new Post();
            $post->setTitle("Article $i");
            $post->setContent("Contenu de démonstration pour l'article $i. Lorem ipsum dolor sit amet...");
            $post->setPicture(null);

            // Author = admin
            $post->setAuthor($this->getReference(UserFixtures::ADMIN_REF, \App\Entity\User::class));


            // Category aléatoire parmi cat_1..cat_5
            $catIndex = rand(1, 5);
            $post->setCategory($this->getReference("cat_$catIndex", \App\Entity\Category::class));


            $manager->persist($post);

            $this->addReference("post_$i", $post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
