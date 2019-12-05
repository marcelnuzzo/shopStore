<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"name"}, message="There is already an account with this name")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
           * getRoles
           *
           * @return array['ROLE_USER']
           */
         /* public function getRoles()
          {
              return ['ROLE_ADMIN'];
          }  
      
          /**
           * eraseCredentials
           *
           * @return void
           */
          public function eraseCredentials()
          {
              
          }
      
      
          /**
           * getSalt
           *
           * @return string | null
           */
          public function getSalt()
          {
              return null;
      
          }
      
          
      	/** @see \Serializable::serialize() */
          public function serialize()
          {
              return serialize([
                  $this->id,
                  $this->user,
                  $this->login,
                  $this->password,
                  // see section on salt below
                  // $this->salt,
              ]);
          }
      
       
          /**
           * unserialize
           *
           * @param  mixed $serialized
           *
           * @return void
           */
          public function unserialize($serialized)
          {
              list (
                  $this->id,
                  $this->user,
                  $this->login,
                  $this->password,
                  // see section on salt below
                  // $this->salt
              ) = unserialize($serialized, ['allowed_classes' => false]);
          }
}
