<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Entity\AbstractEntity;
use App\Entity\Page\Page;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\DescriptionEntityTrait;
use App\Entity\Traits\Site\SiteDomainRegistrationTrait;
use App\Entity\Traits\TitleEntityTrait;
use App\Entity\User;
use App\Repository\Site\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'sites')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\UniqueConstraint(name: 'uniq_domain', columns: ['domain'])]
#[ORM\UniqueConstraint(name: 'uniq_token', columns: ['token'])]
#[ORM\Index(name: 'idx_registrar_email', columns: ['registrar_email'])]
#[ORM\Index(name: 'idx_registered_at', columns: ['registered_at'])]
#[ORM\Index(name: 'idx_expire_at', columns: ['expire_at'])]
#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site extends AbstractEntity
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use DescriptionEntityTrait;
    use SiteDomainRegistrationTrait;

    #[ORM\Column(name: 'domain', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $domain = null;

    #[ORM\Column(name: 'token', type: Types::STRING, length: 40, nullable: true)]
    private ?string $token = null;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $pages;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'sites')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'sites')]
    private Collection $clients;

    #[ORM\OneToOne(targetEntity: SiteSettings::class, mappedBy: 'site', cascade: ['persist'])]
    private ?SiteSettings $settings = null;

    #[ORM\OneToMany(targetEntity: Banner::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $banners;

    public function __construct()
    {
        $this->pages   = new ArrayCollection();
        $this->users   = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->banners = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getId() === null ? 'New Entity' : null;
        $labels[] = $this->getDomain();

        return implode(' ', array_filter($labels));
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): static
    {
        $this->domain = $domain;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->setSite($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getSite() === $this) {
                $page->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addSite($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeSite($this);
        }

        return $this;
    }

    public function getSettings(): ?SiteSettings
    {
        return $this->settings;
    }

    public function setSettings(?SiteSettings $settings): static
    {
        // unset the owning side of the relation if necessary
        if ($settings === null && $this->settings !== null) {
            $this->settings->setSite(null);
        }

        // set the owning side of the relation if necessary
        if ($settings !== null && $settings->getSite() !== $this) {
            $settings->setSite($this);
        }

        $this->settings = $settings;

        return $this;
    }

    /**
     * @return Collection<int, Banner>
     */
    public function getBanners(): Collection
    {
        return $this->banners;
    }

    public function addBanner(Banner $banner): static
    {
        if (!$this->banners->contains($banner)) {
            $this->banners->add($banner);
            $banner->setSite($this);
        }

        return $this;
    }

    public function removeBanner(Banner $banner): static
    {
        if ($this->banners->removeElement($banner)) {
            // set the owning side to null (unless already changed)
            if ($banner->getSite() === $this) {
                $banner->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(User $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->addSite($this);
        }

        return $this;
    }

    public function removeClient(User $client): static
    {
        if ($this->clients->removeElement($client)) {
            $client->removeSite($this);
        }

        return $this;
    }
}
