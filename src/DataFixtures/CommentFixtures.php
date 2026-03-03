<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $messagesApproved = [
            "Super article, c'est très clair 👌",
            "Merci pour l'explication, j'ai appris un truc !",
            "Bon résumé, tu pourrais ajouter un exemple en plus.",
            "J'aime bien la structure, continue comme ça !",
        ];

        $messagesPending = [
            "Je ne suis pas d'accord sur ce point.",
            "Peux-tu préciser la source ?",
            "J'ai une question : pourquoi tu dis ça ?",
        ];

        for ($postId = 1; $postId <= 10; $postId++) {
            $post = $this->getReference("post_$postId", Post::class);

            // 2 approved
            for ($i = 1; $i <= 2; $i++) {
                $comment = new Comment();
                $comment->setContent($messagesApproved[array_rand($messagesApproved)]);
                $comment->setStatus('approved');

                $userIndex = rand(1, 5);
                $comment->setAuthor($this->getReference("user_$userIndex", User::class));
                $comment->setPost($post);

                $manager->persist($comment);
            }

            // 1 pending
            $pending = new Comment();
            $pending->setContent($messagesPending[array_rand($messagesPending)]);
            $pending->setStatus('pending');

            $userIndex = rand(1, 5);
            $pending->setAuthor($this->getReference("user_$userIndex", User::class));
            $pending->setPost($post);

            $manager->persist($pending);
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
