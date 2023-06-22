<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
/**
 * Summary of User
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     * Summary of id
     * @var $id ?int
     */
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    /**
     * Summary of email
     * @var $email string
     */
    private string $email = '';

    #[ORM\Column]
    /**
     * Summary of roles
     * @var $roles array
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    /**
     * Summary of first_name
     * @var $first_name ?string 
     */
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    /**
     * Summary of last_name
     * @var $last_name ?string
     */
    private ?string $last_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    /**
     * Summary of avatar
     * @var $avatar ?string 
     */
    private ?string $avatar = null;

    #[ORM\Column(length: 255)]
    /**
     * Summary of username
     * @var $username ?string 
     */
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Place::class, orphanRemoval: true)]
    /**
     * Summary of places
     * @var $places Collection
     */
    private Collection $places;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->places = new ArrayCollection();
        $this->roles = [];
    }

    /**
     * Summary of getId
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of getEmail
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Summary of setEmail
     * @param mixed $email
     * @return \App\Entity\User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    // /**
    //  * A visual identifier that represents this user.
    //  *
    //  * @see UserInterface
    //  */
    /**
     * Summary of getUserIdentifier
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // /**
    //  * @see UserInterface
    //  */
    /**
     * Summary of getRoles
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Summary of setRoles
     * @param mixed $roles
     * @return \App\Entity\User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    // /**
    //  * @see PasswordAuthenticatedUserInterface
    //  */
    /**
     * Summary of getPassword
     * @return string|null
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Summary of setPassword
     * @param mixed $password
     * @return \App\Entity\User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    // /**
    //  * @see UserInterface
    //  */
    /**
     * Summary of eraseCredentials
     * @return void
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Summary of getFirstName
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * Summary of setFirstName
     * @param mixed $first_name
     * @return \App\Entity\User
     */
    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Summary of getLastName
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * Summary of setLastName
     * @param mixed $last_name
     * @return \App\Entity\User
     */
    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Summary of getAvatar
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Summary of setAvatar
     * @param mixed $avatar
     * @return \App\Entity\User
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Summary of getUsername
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Summary of setUsername
     * @param mixed $username
     * @return \App\Entity\User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Place>
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    /**
     * Summary of addPlace
     * @param \App\Entity\Place $place
     * @return \App\Entity\User
     */
    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places->add($place);
            $place->setAuthor($this);
        }

        return $this;
    }

    /**
     * Summary of removePlace
     * @param \App\Entity\Place $place
     * @return \App\Entity\User
     */
    public function removePlace(Place $place): self
    {
        if ($this->places->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getAuthor() === $this) {
                $place->setAuthor(null);
            }
        }

        return $this;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
