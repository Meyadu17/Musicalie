<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 2)]
    private ?string $code = null;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Festival::class)]
    private Collection $festivals;

    public function __construct()
    {
        $this->festivals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Festival>
     */
    public function getFestivals(): Collection
    {
        return $this->festivals;
    }

    public function addFestival(Festival $festival): static
    {
        if (!$this->festivals->contains($festival)) {
            $this->festivals->add($festival);
            $festival->setDepartement($this);
        }

        return $this;
    }

    public function removeFestival(Festival $festival): static
    {
        if ($this->festivals->removeElement($festival)) {
            // set the owning side to null (unless already changed)
            if ($festival->getDepartement() === $this) {
                $festival->setDepartement(null);
            }
        }

        return $this;
    }
}
