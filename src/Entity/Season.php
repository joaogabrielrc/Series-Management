<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
#[ORM\Table(name: 'seasons')]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'season', targetEntity: Episode::class, orphanRemoval: true)]
    private Collection $episodes;

    public function __construct(
        #[ORM\Column]
        private int $number,

        #[ORM\ManyToOne(inversedBy: 'seasons')]
        #[ORM\JoinColumn(nullable: false)]
        private Series $series
    )
    {
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): void
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes->add($episode);
            $episode->setSeason($this);
        }
    }

    /**
     * @return Series
     */
    public function getSeries(): Series
    {
        return $this->series;
    }

    /**
     * @param Series $series
     */
    public function setSeries(Series $series): void
    {
        $this->series = $series;
    }

//    public function removeEpisode(Episode $episode): void
//    {
//        if ($this->episodes->removeElement($episode)) {
//            if ($episode->getSeason() === $this) {
//                $episode->setSeason(null);
//            }
//        }
//    }
}
