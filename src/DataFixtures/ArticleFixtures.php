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
                        ->setContent($faker->paragraph($nbSentences = 10, $variableNbSentences = true))
                        ->setImage($faker->imageUrl($width = 400, $height = 200))
                        ->setCreatedAt(new \DateTime())
                        ->setCategory($categorie);

                $manager->persist($article);
               
                for($k=1; $k<=10; $k++) {
                    $comment = new Commentaire();
                    $comment->setAuthor($faker->userName())
                            ->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                            ->setCreatedAt(new \DateTime())
                            ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}