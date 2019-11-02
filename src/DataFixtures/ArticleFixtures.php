<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i=1; $i<=10; $i++) {
           
            $article = new Article();
            $article ->setTitle("article n°$i")
                     ->setContent("contenu n°$i")
                     ->setImage("http://placehold.com/350*150")
                     ->setCreatedAt(new \DateTime());


            $manager->persist($article);

        }

        $manager->flush();
    }
}
