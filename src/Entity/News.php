<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class News
{
    const UPLOAD_FOLDER = 'news';
    const FORM_ROUTES = [
        'index' => 'news_index',
        'new' => 'news_new',
        'edit' => 'news_edit',
    ];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titel;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $subtitel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="news" , cascade={"persist","remove"})
     * @var ArrayCollection|PersistentCollection $files
     */
    private $files;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $teaser;


    public function __construct()
    {
        $this->setCreatedAt((new DateTime()));
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getSubtitel(): ?string
    {
        return $this->subtitel;
    }

    public function setSubtitel(?string $subtitel): self
    {
        $this->subtitel = $subtitel;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setNews($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getNews() === $this) {
                $file->setNews(null);
            }
        }

        return $this;
    }

    public function getTeaser(): ?string
    {
        return $this->teaser;
    }

    public function setTeaser(?string $teaser): self
    {
        $this->teaser = $teaser;

        return $this;
    }
}
