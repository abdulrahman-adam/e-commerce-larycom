<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        
        $faker = Factory::create();
        for($i = 0; $i < 11; $i++) {

            $product = new Product();
            $product->setName($faker->words(3, true))
                    ->setType($faker->words(2, true))
                    ->setOriginal($faker->words(2, true))
                    ->setPrice($faker->randomFloat(1, 500, 1000));
            $manager->persist($product);

            for($k = 0; $k < 3; $k++) {
                $article = new Article();
                $article->setName($faker->words(3, true))
                        ->setContent($faker->text())
                        ->setPrice($faker->randomFloat(1, 500, 1000))
                        ->setProduct($product);
            $manager->persist($article);

            }
        }

        $manager->flush();
    }
}
