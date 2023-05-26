<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Place $place = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $alt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $url = null;

    /**
     * Summary of getId
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Summary of getName
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Summary of setName
     * @param mixed $name
     * @return \App\Entity\Photo
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Summary of getPlace
     * @return Place|null
     */
    public function getPlace(): ?Place
    {
        return $this->place;
    }

    /**
     * Summary of setPlace
     * @param mixed $place
     * @return \App\Entity\Photo
     */
    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Summary of getAlt
     * @return string|null
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }

    /**
     * Summary of setAlt
     * @param mixed $alt
     * @return \App\Entity\Photo
     */
    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Summary of getDescription
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Summary of setDescription
     * @param mixed $description
     * @return \App\Entity\Photo
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Summary of getUrl
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Summary of setUrl
     * @param mixed $url
     * @return \App\Entity\Photo
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
