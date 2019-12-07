<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @Assert\EqualTo(propertyPath="password", message = "le mot de passe doit être le même que dans password")
     */
    public $confirm_password;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=50,  minMessage = "Votre nom est trop court", maxMessage = "Votre nom est trop long")
     * @Assert\NotNull(message="Le nom d'utilisateur ne peut pas être nul")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "Ce n'est pas une adresse e-mail valide")
     * @Assert\NotNull(message="L'email ne peut pas être nul")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $login;

    // /**
    // * @ORM\Column(type="string", length=255)
    // */
    // private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, minMessage = "Votre mot de passe doit faire minimun 2 caractères")
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getRoles()
    {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }

        return $this->roles;
    }

    /*
    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    */

    /*
    public function getRoles()
    {
        return ['ROLE_USER',
                'ROLE_ADMIN'
        ];
    }
    */

    /**
     * eraseCredentials.
     */
    public function eraseCredentials()
    {
    }

    /**
     * getSalt.
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
            $this->username,
            $this->login,
            $this->password,
            $this->confirm_password,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /**
     * unserialize.
     *
     * @param mixed $serialized
     */
    public function unserialize($serialized)
    {
        list(
                $this->id,
                $this->username,
                $this->login,
                $this->password,
                $this->confirm_password,
                // see section on salt below
                // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
