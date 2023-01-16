<?php

namespace App\Entity;

use App\Repository\PaintingRepository;
use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PaintingRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(
    fields: ['title'], message: 'Ce titre existe déjà',
)]
class Painting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Le titre doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Le titre doit contenir au maximum {{ limit }} caractères',
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 7,
        minMessage: 'Cette description doit contenir au minimum {{ limit }} caractères',
    )]
    private ?string $smallDescription = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $fullDescription = null;


    #[ORM\Column]
    private ?\DateTimeImmutable $created = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 50,
        message: 'Le tableau doit mesurer au minimum {{ compared_value }} cm de hauteur'
    )]
    private ?int $height = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 50,
        message: 'Le tableau doit mesurer au minimum {{ compared_value }} cm de largeur'
    )]
    private ?int $width = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Technical $technical = null;

    #[ORM\OneToMany(mappedBy: 'painting', targetEntity: Comment::class)]
    private Collection $comment;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'painting', targetEntity: PaintingLike::class)]
    private Collection $likes;

    #[ORM\Column]
    private ?bool $isSold = null;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getSmallDescription(): ?string
    {
        return $this->smallDescription;
    }

    public function setSmallDescription(string $smallDescription): self
    {
        $this->smallDescription = $smallDescription;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getCreated(): ?\DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(\DateTimeImmutable $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTechnical(): ?Technical
    {
        return $this->technical;
    }

    public function setTechnical(?Technical $technical): self
    {
        $this->technical = $technical;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function createSlug() {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->title);
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment->add($comment);
            $comment->setPainting($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPainting() === $this) {
                $comment->setPainting(null);
            }
        }

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, PaintingLike>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(PaintingLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setPainting($this);
        }

        return $this;
    }

    public function removeLike(PaintingLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPainting() === $this) {
                $like->setPainting(null);
            }
        }

        return $this;
    }


    /** Permet de savoir si la peinture est likée par un user
     * @param \App\Entity\User $user
     * @return bool
     */
    public function isLikedByUser(User $user) : bool {
        foreach($this->likes as $like) {
            if($like->getUser() === $user)
                return true;
            }
            return false;
    }

    // EAsyAdmin - classes relationnelles
    public function __toString(): string
    {
        return ucFirst($this->title);
    }

    public function isIsSold(): ?bool
    {
        return $this->isSold;
    }

    public function setIsSold(bool $isSold): self
    {
        $this->isSold = $isSold;

        return $this;
    }
}
