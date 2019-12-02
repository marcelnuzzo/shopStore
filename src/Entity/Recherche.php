<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RechercheRepository")
 */
class Recherche
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titreArticle;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoryArticle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreArticle(): ?string
    {
        return $this->titreArticle;
    }

    public function setTitreArticle(?string $titreArticle): self
    {
        $this->titreArticle = $titreArticle;

        return $this;
    }

    public function getCategoryArticle(): ?int
    {
        return $this->categoryArticle;
    }

    public function setCategoryArticle(?int $categoryArticle): self
    {
        $this->categoryArticle = $categoryArticle;

        return $this;
    }
}
