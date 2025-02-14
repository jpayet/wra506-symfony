<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['movie:read']
    ],
    denormalizationContext: [
        'groups' => ['movie:write'],
    ],
    paginationClientEnabled: true,
    security: "is_granted('ROLE_USER')",
)]
#[Get]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Put(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write', 'actor:read', 'category:read'])]
    #[Assert\NotBlank(
        message: 'Le titre est obligatoire'
    )]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(
        message: 'La description est obligatoire'
    )]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La description doit faire 5 caractères minimum',
        maxMessage: 'La description ne doit pas excéder les 255 caractères'
    )]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\Length(
        min: 10,
        max: 10,
        minMessage: 'La date doit être au format JJ/MM/AAAA',
        maxMessage: 'La date doit être au format JJ/MM/AAAA'
    )]
    private ?string $releaseDate = null;

    #[ORM\Column]
    #[Groups(['movie:read', 'movie:write'])]
    #[Assert\NotBlank(
        message: 'La durée est obligatoire'
    )]
    #[Assert\Type(
        type: 'integer',
        message: 'La durée entrée "{{ value }}" n\'est pas dans le bon format ({{ type }}).',
    )]
    #[ApiFilter(RangeFilter::class, strategy: 'partial')]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['movie:read', 'movie:write'])]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['movie:read', 'movie:write'])]
    private Collection $actor;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?User $auteur = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    #[ApiFilter(BooleanFilter::class, properties: ['online'])]
    private ?bool $online = null;

    #[ORM\OneToOne(inversedBy: 'movie', cascade: ['persist', 'remove'])]
    #[Groups(['movie:read', 'movie:write'])]
    private ?MediaObject $Media = null;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(?bool $online): static
    {
        $this->online = $online;

        return $this;
    }

    public function getMedia(): ?MediaObject
    {
        return $this->Media;
    }

    public function setMedia(?MediaObject $Media): static
    {
        $this->Media = $Media;

        return $this;
    }
}
