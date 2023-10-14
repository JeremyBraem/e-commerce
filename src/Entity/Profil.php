<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use App\Traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
#[HasLifecycleCallbacks]
class Profil
{

    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $rs = null;

    #[ORM\OneToOne(mappedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?Users $users = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getRs(): ?string
    {
        return $this->rs;
    }

    public function setRs(string $rs): static
    {
        $this->rs = $rs;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): static
    {
        // unset the owning side of the relation if necessary
        if ($users === null && $this->users !== null) {
            $this->users->setProfile(null);
        }

        // set the owning side of the relation if necessary
        if ($users !== null && $users->getProfile() !== $this) {
            $users->setProfile($this);
        }

        $this->users = $users;

        return $this;
    }

    public function __toString()
    {
        return $this->rs. " ".$this->url;
    }
}
