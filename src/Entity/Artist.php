<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;



    #[ORM\Column(type: Types::TEXT)]
    private ?string $biography = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birthDate = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'artist', targetEntity: Painting::class)]
    private Collection $painting;

    public function __construct()
    {
        $this->painting = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function createSlug() {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->lastName);
    }

    /**
     * @return Collection<int, Painting>
     */
    public function getPainting(): Collection
    {
        return $this->painting;
    }

    public function addPainting(Painting $painting): self
    {
        if (!$this->painting->contains($painting)) {
            $this->painting->add($painting);
            $painting->setArtist($this);
        }

        return $this;
    }

    public function removePainting(Painting $painting): self
    {
        if ($this->painting->removeElement($painting)) {
            // set the owning side to null (unless already changed)
            if ($painting->getArtist() === $this) {
                $painting->setArtist(null);
            }
        }
        return $this;
    }

    // EAsyAdmin - classes relationnelles
    public function __toString(): string
    {
        return $this->lastName . ' ' . $this->firstName;
    }

}
