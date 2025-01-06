<?php

namespace App\Entity;

use App\Repository\ClientsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientsRepository")
 */
class Clients implements UserInterface
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
     * @Assert\NotBlank(message="Le prénom est obligatoire.")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse e-mail est obligatoire.")
     * @Assert\Email(message="Veuillez entrer une adresse e-mail valide.")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le mot de passe est obligatoire.")
     */
    private $mdp;

    /**
     * @ORM\Column(type="integer")
     */
    private $budget;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $role = 1;  // Rôle par défaut (1 pour client)

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
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

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): self
    {
        $this->budget = $budget;
        return $this;
    }

    // Ajout de la gestion du rôle
    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->mail;  // Retourne l'email comme identifiant unique
    }

    public function getRoles(): array
    {
        // Vous pouvez gérer le rôle selon le champ "role" en base de données
        return ['ROLE_CLIENT'];  // Le rôle par défaut est "ROLE_CLIENT"
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
