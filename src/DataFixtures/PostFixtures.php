<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Images par catégorie (tu adaptes les noms à tes catégories)
        $imagesByCategory = [
            'Tech'    => [
                'https://images.unsplash.com/photo-1518779578993-ec3579fee39f?auto=format&fit=crop&w=1200&q=60',
                'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=60',
            ],
            'Sport'   => [
                'https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=1200&q=60',
                'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1200&q=60',
            ],
            'Cinéma'  => [
                'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1200&q=60',
                'https://images.unsplash.com/photo-1517602302552-471fe67acf66?auto=format&fit=crop&w=1200&q=60',
            ],
            'Musique' => [
                'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=1200&q=60',
                'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1200&q=60',
            ],
            'Gaming'  => [
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=1200&q=60',
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=1200&q=60',
            ],
        ];

        // Tes références catégories: cat_1..cat_5 (créées dans CategoryFixtures)
        for ($i = 1; $i <= 10; $i++) {
            $catIndex = rand(1, 5);
            $category = $this->getReference("cat_$catIndex", Category::class);


            // On récupère le nom via __toString() (tu l'as)
            $catName = (string) $category;

            $pictures = $imagesByCategory[$catName] ?? [];
            $picture = $pictures ? $pictures[array_rand($pictures)] : null;

            $post = new Post();
            $post->setTitle("Article $i - $catName");
            $post->setContent(
                "Ceci est un article de démonstration sur la catégorie $catName.\n\n".
                "✅ Points clés :\n".
                "- Exemple de contenu\n".
                "- Style Bootstrap\n".
                "- Commentaires validés par l'admin\n\n".
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
            );
            $post->setPicture($picture);

            // Auteur = admin
            $post->setAuthor($this->getReference(UserFixtures::ADMIN_REF, User::class));
            $post->setCategory($category);

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
