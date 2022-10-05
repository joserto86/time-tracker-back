<?php

namespace App\Entity\Main;

use App\Repository\Main\AppUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AppUserRepository::class)]
class AppUser implements UserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'appUser', targetEntity: AppUserInstance::class)]
    private Collection $appUserInstances;

    public function __construct()
    {
        $this->appUserInstances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public static function createFromPayload($username, array $payload)
    {
        $admin = new AppUser();
        return $admin->setUsername($username);
    }

    /**
     * @return Collection<int, AppUserInstance>
     */
    public function getAppUserInstances(): Collection
    {
        return $this->appUserInstances;
    }

    public function addAppUserInstance(AppUserInstance $appUserInstance): self
    {
        if (!$this->appUserInstances->contains($appUserInstance)) {
            $this->appUserInstances->add($appUserInstance);
            $appUserInstance->setAppUser($this);
        }

        return $this;
    }

    public function removeAppUserInstance(AppUserInstance $appUserInstance): self
    {
        if ($this->appUserInstances->removeElement($appUserInstance)) {
            // set the owning side to null (unless already changed)
            if ($appUserInstance->getAppUser() === $this) {
                $appUserInstance->setAppUser(null);
            }
        }

        return $this;
    }
}
