<?php

namespace App\Entity\Main;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\Main\InstanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: InstanceRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/instance/{id}',
            routeName: 'instance-item',
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(
            routeName: 'instance-list',
            name: 'list'
        ),
        new Post(
            routeName: 'instance-post-token',
            description: 'Set token for instance',
            name: 'post-token'
        )
    ],
    normalizationContext: ['groups' => ['list']]
)]
class Instance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['list'])]
    private ?string $url = null;

    #[ORM\OneToMany(mappedBy: 'instance', targetEntity: AppUserInstance::class)]
    private Collection $appUserInstances;

    public function __construct()
    {
        $this->appUserInstances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, AppUserInstance>
     */
    public function getAppUserInstances(): Collection
    {
        return $this->appUserInstances;
    }

    public function addAdminInstance(AppUserInstance $appUserInstance): self
    {
        if (!$this->appUserInstances->contains($appUserInstance)) {
            $this->appUserInstances->add($appUserInstance);
            $appUserInstance->setInstance($this);
        }

        return $this;
    }

    public function removeAdminInstance(AppUserInstance $appUserInstance): self
    {
        if ($this->appUserInstances->removeElement($appUserInstance)) {
            // set the owning side to null (unless already changed)
            if ($appUserInstance->getInstance() === $this) {
                $appUserInstance->setInstance(null);
            }
        }

        return $this;
    }
}
