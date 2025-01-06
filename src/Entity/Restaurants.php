<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantsRepository")
 */
class Restaurants implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse est obligatoire.")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Le code postal est obligatoire.")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La ville est obligatoire.")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse e-mail est obligatoire.")
     * @Assert\Email(message="Veuillez entrer une adresse e-mail valide.")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire.")
     * @Assert\Length(
     *     min=8,
     *     minMessage="Le mot de passe doit contenir au moins {{ limit }} caractères."
     * )
     * @Assert\Regex("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/")
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $distance;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_minimum; 

    // Getters et setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(?string $distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    public function getPrixMinimum(): ?float
    {
        return $this->prix_minimum;
    }

    public function setPrixMinimum(?float $prix_minimum): self
    {
        $this->prix_minimum = $prix_minimum;
        return $this;
    }
    

    public function getUserIdentifier(): string
    {
        return $this->mail;  // Retourne l'email comme identifiant unique
    }

    public function getRoles(): array
    {
        return ['ROLE_RESTAURANT'];  // Le restaurant a ce rôle
    }

    public function getPassword(): string
    {
        return $this->mdp;  // Retourne le mot de passe haché
    }

    public function getSalt(): ?string
    {
        return null;  // bcrypt ou argon2 n'ont pas besoin de sel
    }

    public function eraseCredentials(): void
    {
        // Si tu stockais des informations sensibles supplémentaires (en plus du mot de passe)
    }

    public function getUsername(): string
    {
        return $this->mail;  // Nom d'utilisateur (email dans ce cas)
    }
}