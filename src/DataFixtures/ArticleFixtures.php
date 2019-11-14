<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $faker = \Faker\Factory::create();

        for($i = 1; $i <= 5; $i++) {
            $categorie=new Category();
            $categorie->setContent($faker->sentence())
                     ->setDescription($faker->paragraph($nbSentences = 5, $variableNbSentences = true));

            $manager->persist($categorie);
            
            for($j=1; $j<=10; $j++) {
            
                $article = new Article();
                $article ->setTitle($faker->sentence())
                        ->setContent($faker->realText($maxNbChars = 200, $indexSize = 2))
                        ->setImage($faker->imageUrl($width = 400, $height = 200))
                        ->setCreatedAt($faker->dateTimeBetween($startDate = '-3days', $endDate = 'now', $timezone = null))
                        ->setCategory($categorie);

                $manager->persist($article);
               
                for($k=1; $k<=10; $k++) {
                    $comment = new Commentaire();
                    $comment->setAuthor($faker->name())
                           ->setContent($faker->paragraph())
                           ->setCreatedAt(new \DateTime())
                           ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}