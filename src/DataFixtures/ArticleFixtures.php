<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i <= 3; $i++) {
            $categorie=new Category();
            $category->setContent("contenu n°$i")
                     ->setDescription("description n°$i");

            $manager->persist($categorie);
        
            for($j=1; $j<=50; $j++) {
            
                $article = new Article();
                $article ->setTitle("article n°$j")
                        ->setContent("contenu n°$j")
                        ->setImage("http://placehold.com/350*150")
                        ->setCreatedAt(new \DateTime())
                        ->setCategory($categorie);

                $manager->persist($article);

                for($k=1; $k<=5; $k++) {
                    $comment = new Commentaire();
                    $comment->setAuthor("auteur n°$k")
                            ->setContent("contenu n°$k")
                            ->setCreatedAt(new \DateTime())
                            ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
