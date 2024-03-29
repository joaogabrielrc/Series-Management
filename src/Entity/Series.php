<?php

namespace App\Entity;

use App\Repository\SeriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeriesRepository::class)]
#[ORM\Table(name: 'series')]
class Series
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToMany(mappedBy: 'series', targetEntity: Season::class, orphanRemoval: true)]
    private Collection $seasons;

    public function __construct(
        #[ORM\Column(length: 255)]
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        private string $name
    )
    {
        $this->seasons = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection<Season[]>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    /**
     * @param Season $season
     */
    public function addSeason(Season $season): void
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSeries($this);
        }
    }
}
