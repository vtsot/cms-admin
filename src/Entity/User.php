<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Dictionary\User\UserRole;
use App\Contract\Entity\UserInterface;
use App\Entity\Site\Site;
use App\Entity\Traits\ActiveEntityTrait;
use App\Repository\UserRepository;
use Carbon\CarbonImmutable;
use Deprecated;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function array_filter;
use function implode;
use function in_array;

#[ORM\Table(name: 'users')]
#[ORM\Index(name: 'idx_active', columns: ['active'])]
#[ORM\Index(name: 'idx_google_authenticator_enabled', columns: ['is_google_authenticator_enabled'])]
#[ORM\UniqueConstraint(name: 'uniq_email', columns: ['email'])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements UserInterface
{
    use ActiveEntityTrait;

    #[ORM\Column(name: 'first_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: 'last_name', type: Types::STRING, length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(name: 'email', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $email = null;

    private ?string $plainPassword = null;

    #[ORM\Column(name: 'password', type: Types::STRING, length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(name: 'roles', type: Types::JSON, nullable: false)]
    private array $roles;

    #[ORM\Column(name: 'is_google_authenticator_enabled', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private bool $googleAuthenticatorEnabled = false;

    #[ORM\Column(name: 'google_authenticator_token', type: Types::STRING, length: 255, nullable: true)]
    private ?string $googleAuthenticatorToken = null;

    #[ORM\ManyToMany(targetEntity: Site::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_sites')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'site_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $sites;

    public function __construct()
    {
        $this->roles     = [UserRole::SiteManager->value];
        $this->createdAt = new CarbonImmutable();
        $this->sites     = new ArrayCollection();
    }

    public function __toString(): string
    {
        $labels   = [];
        $labels[] = $this->getId() === null ? 'New Entity' : null;
        $labels[] = $this->getFullName();
        $labels[] = ' (' . $this->getEmail() . ')';

        return implode(' ', array_filter($labels));
    }

    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $password): static
    {
        $this->plainPassword = $password;

        // required to trigger update if only password changed
        $this
            ->setUpdatedAt(new CarbonImmutable());

        return $this;
    }

    #[Deprecated]
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles(), true);
    }

//    public function __serialize(): array
//    {
//        return [
//            $this->id,
//            $this->email,
//            $this->password,
//            $this->roles,
//            $this->active,
//        ];
//    }
//
//    public function __unserialize(array $data): void
//    {
//        [
//            $this->id,
//            $this->email,
//            $this->password,
//            $this->roles,
//            $this->active,
//        ] = $data;
//    }

    public function getFullName(): string
    {
        return implode(' ', [$this->firstName, $this->lastName]);
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return $this->googleAuthenticatorEnabled;
    }

    public function setGoogleAuthenticatorEnabled(bool $googleAuthenticatorEnabled): self
    {
        $this->googleAuthenticatorEnabled = $googleAuthenticatorEnabled;

        return $this;
    }

    public function getGoogleAuthenticatorToken(): ?string
    {
        return $this->googleAuthenticatorToken;
    }

    public function setGoogleAuthenticatorToken(?string $googleAuthenticatorToken): self
    {
        $this->googleAuthenticatorToken = $googleAuthenticatorToken;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        $this->sites->removeElement($site);

        return $this;
    }
}
