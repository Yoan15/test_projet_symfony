<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create();
        $user = [];

        for ($i=0; $i < 10; $i++) { 
            $user = new User();
            $user->setUsername($faker->name);
            $user->setFirstname($faker->firstname());
            $user->setLastname($faker->lastname());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;
        }

        $categories = [];

        for ($i=0; $i < 15; $i++) { 
            $category = new Category();
            $category->setTitle($faker->text(50));
            $category->setDescription($faker->text(250));
            $category->setImage($faker->imageUrl());
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i=0; $i < 50; $i++) { 
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->text(1000));
            $article->setImage($faker->imageUrl());
            $article->setCreatedAt(new \DateTime());
            $article->addCategory($categories[$faker->numberBetween(0, 14)]);
            $article->setAuthor($users[$faker->numberBetween(0, 9)]);
            $manager->persist($article);
        }

        $manager->flush();
    }
}
