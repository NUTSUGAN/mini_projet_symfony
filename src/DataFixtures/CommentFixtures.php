<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($postId = 1; $postId <= 10; $postId++) {
            // 3 commentaires par post
            for ($i = 1; $i <= 3; $i++) {
                $comment = new Comment();
                $comment->setContent("Commentaire $i du post $postId.");

                // Auteur aléatoire user_1..user_5
                $userIndex = rand(1, 5);
                $comment->setAuthor($this->getReference("user_$userIndex", \App\Entity\User::class));


                // Lien vers le post
                $comment->setPost($this->getReference("post_$postId", \App\Entity\Post::class));


                // 2 approved, 1 pending (exemple)
                $comment->setStatus($i <= 2 ? 'approved' : 'pending');

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
