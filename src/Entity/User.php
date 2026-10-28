<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\UserInterface;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\User\GoogleAuthenticatorEntityTrait;
use App\Entity\Traits\User\UserNameEntityTrait;
use App\Entity\Traits\User\UserPasswordEntityTrait;
use App\Entity\Traits\User\UserRolesEntityTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;

#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'uniq_email', columns: ['email'])]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'idx_google_authenticator_enabled', columns: ['is_google_authenticator_enabled'])]
#[ORM\Index(name: 'idx_google_authenticator_token', columns: ['google_authenticator_token'])]
#[ORM\UniqueConstraint(name: 'uniq_email', columns: ['email'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface
{
    use ActiveEntityTrait;
    use UserNameEntityTrait;
    use GoogleAuthenticatorEntityTrait;
    use UserPasswordEntityTrait;
    use UserRolesEntityTrait;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: Site::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_sites')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'site_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $sites;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = !$this->getId() ? 'New Entity' : null;
        $labels[] = $this->getFullName();
        $labels[] = ' (' . $this->getEmail() . ')';
        $labels[] = !$this->isActive() ? '(inactive)' : null;

        return implode(' ', array_filter($labels));
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): static
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
        }

        return $this;
    }

    public function removeSite(Site $site): static
    {
        $this->sites->removeElement($site);

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Site $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
        }

        return $this;
    }

    public function removeClient(Site $client): static
    {
        $this->clients->removeElement($client);

        return $this;
    }
}
