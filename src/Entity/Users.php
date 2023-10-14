<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\HasLifecycleCallbacks()]

class Users
{

    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $fistname = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $age = null;

    #[ORM\OneToOne(inversedBy: 'users', cascade: ['persist', 'remove'])]
    private ?Profil $profile = null;

    #[ORM\ManyToMany(targetEntity: Hobby::class)]
    private Collection $hobbie;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Job $Job = null;

    

    public function __construct()
    {
        $this->hobbie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFistname(): ?string
    {
        return $this->fistname;
    }

    public function setFistname(string $fistname): static
    {
        $this->fistname = $fistname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getProfile(): ?Profil
    {
        return $this->profile;
    }

    public function setProfile(?Profil $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbie(): Collection
    {
        return $this->hobbie;
    }

    public function addHobbie(Hobby $hobbie): static
    {
        if (!$this->hobbie->contains($hobbie)) {
            $this->hobbie->add($hobbie);
        }

        return $this;
    }

    public function removeHobbie(Hobby $hobbie): static
    {
        $this->hobbie->removeElement($hobbie);

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->Job;
    }

    public function setJob(?Job $Job): static
    {
        $this->Job = $Job;

        return $this;
    }
}
