<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['actor:read']
    ],
    denormalizationContext: [
        'groups' => ['actor:write']
    ],
    security: "is_granted('ROLE_USER')",
)]
#[Get]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Put(security: "is_granted('ROLE_ADMIN')")]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['actor:read', 'movie:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'actor:read', 'actor:write'])]
    #[Assert\NotBlank(
        message: 'Le prénom est obligatoire'
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\-]+$/",
        message:"Le prénom ne peut contenir que des lettres, des chiffres et le caractère '-'."
    )]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read', 'actor:read', 'actor:write'])]
    #[Assert\NotBlank(
        message: 'Le nom est obligatoire'
    )]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9\-]+$/",
        message:" Le nom ne peut contenir que des lettres, des chiffres et le cracatère '-'."
    )]
    private ?string $lastName = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actor')]
    #[Groups(['actor:read', 'actor:write'])]
    private Collection $movies;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'actors')]
    #[Groups(['actor:read','actor:write'])]
    private ?Nationalite $nationalite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['actor:read','actor:write'])]
    private ?\DateTimeInterface $DateOfBirthday = null;


    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): static
    {
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
            $movie->addActor($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): static
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeActor($this);
        }

        return $this;
    }

    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): static
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getDateOfBirthday(): ?\DateTimeInterface
    {
        return $this->DateOfBirthday;
    }

    public function setDateOfBirthday(?\DateTimeInterface $DateOfBirthday): static
    {
        $this->DateOfBirthday = $DateOfBirthday;

        return $this;
    }
}
