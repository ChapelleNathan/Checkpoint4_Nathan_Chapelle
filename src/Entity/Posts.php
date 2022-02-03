<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostsRepository")
 * @Vich\Uploadable
 */
class Posts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $picturePath;

    /**
     * @Vich\UploadableField(mapping="post_file", fileNameProperty="picturePath")
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="likes")
     */
    private $liked;

    /**
     * @ORM\OneToMany(targetEntity=Comments::class, mappedBy="post")
     */
    private $comments;

    public function __construct()
    {
        $this->liked = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function setPictureFile(File $image = null): Posts
    {
        $this->pictureFile = $image;
        if($image) {
            $this->setUpdatedAt(new DateTime());
        }
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLiked(): Collection
    {
        return $this->liked;
    }

    public function addLiked(User $liked): self
    {
        if (!$this->liked->contains($liked)) {
            $this->liked[] = $liked;
            $liked->addLike($this);
        }

        return $this;
    }

    public function removeLiked(User $liked): self
    {
        if ($this->liked->removeElement($liked)) {
            $liked->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }
}
