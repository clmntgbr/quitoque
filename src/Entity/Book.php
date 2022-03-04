<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    use TimestampableEntity;

    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $title;

    /**
     * @var string|null
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type("string")
     */
    private $releaseDate;

    /**
     * @var BookAuthor|null
     * @ORM\ManyToOne(targetEntity=BookAuthor::class, cascade={"persist"}, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    public $bookAuthor;

    /**
     * @var BookType|null
     * @ORM\ManyToOne(targetEntity=BookType::class, cascade={"persist"}, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    public $bookType;

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

    public function getBookAuthor(): ?BookAuthor
    {
        return $this->bookAuthor;
    }

    public function setBookAuthor(?BookAuthor $bookAuthor): self
    {
        $this->bookAuthor = $bookAuthor;

        return $this;
    }

    public function getBookType(): ?BookType
    {
        return $this->bookType;
    }

    public function setBookType(?BookType $bookType): self
    {
        $this->bookType = $bookType;

        return $this;
    }

    public function getReleaseDate(): ?string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }
}
