<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNSFW;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ranking", mappedBy="category")
     */
    private $rankings;

    public function __construct()
    {
        $this->rankings = new ArrayCollection();
    }

    public function getId()
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

    public function getIsNSFW(): ?bool
    {
        return $this->isNSFW;
    }

    public function setIsNSFW(bool $isNSFW): self
    {
        $this->isNSFW = $isNSFW;

        return $this;
    }

    /**
     * @return Collection|Ranking[]
     */
    public function getRankings(): Collection
    {
        return $this->rankings;
    }

    public function addRanking(Ranking $ranking): self
    {
        if (!$this->rankings->contains($ranking)) {
            $this->rankings[] = $ranking;
            $ranking->setCategory($this);
        }

        return $this;
    }

    public function removeRanking(Ranking $ranking): self
    {
        if ($this->rankings->contains($ranking)) {
            $this->rankings->removeElement($ranking);
            // set the owning side to null (unless already changed)
            if ($ranking->getCategory() === $this) {
                $ranking->setCategory(null);
            }
        }

        return $this;
    }
}
