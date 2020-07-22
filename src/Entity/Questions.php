<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionsRepository")
 */
class Questions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="question")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Responses", mappedBy="question",  cascade={"persist", "remove"})
     */
    private $response;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tags", inversedBy="question")
     */
    private $tags;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $restricted;

    public function __construct()
    {
        $this->response = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function __toString()
    {
        return $this->tags;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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

    /**
     * @return Collection|Responses[]
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }

    public function addResponse(Responses $response): self
    {
        if (!$this->response->contains($response)) {
            $this->response[] = $response;
            $response->setQuestion($this);
        }

        return $this;
    }

    public function removeResponse(Responses $response): self
    {
        if ($this->response->contains($response)) {
            $this->response->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getQuestion() === $this) {
                $response->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addQuestion($this);
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeQuestion($this);
        }

        return $this;
    }

    public function getRestricted(): ?bool
    {
        return $this->restricted;
    }

    public function setRestricted(?bool $restricted): self
    {
        $this->restricted = $restricted;

        return $this;
    }
}
