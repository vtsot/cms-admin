<?php

declare(strict_types=1);
//
//namespace App\Entity\Locale;
//
//use App\Repository\LocaleRepository;
//use Doctrine\DBAL\Types\Types;
//use Doctrine\ORM\Mapping as ORM;
//
//use function strtolower;
//use function substr;
//
//#[ORM\Table(name: 'locales')]
//#[ORM\UniqueConstraint(name: 'uniq_code', columns: ['code'])]
//#[ORM\UniqueConstraint(name: 'uniq_prefix', columns: ['prefix'])]
//#[ORM\Index(columns: ['default'], name: 'idx_default')]
//#[ORM\Index(columns: ['active'], name: 'idx_active')]
//#[ORM\Entity(repositoryClass: LocaleRepository::class)]
//class Locale extends AbstractEntity
//{
//    #[ORM\Column(name: 'code', type: Types::STRING, length: 5, unique: true, nullable: false)]
//    private ?string $code = null;
//
//    #[ORM\Column(name: 'prefix', type: Types::STRING, length: 10, unique: true, nullable: false)]
//    private ?string $prefix = null;
//
//    #[ORM\Column(name: '`default`', type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
//    private bool $default = false;
//
//    #[ORM\Column(name: 'active', type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
//    private bool $active = true;
//
//    public function __toString(): string
//    {
//        return $this->getCode() ?? 'New Entity';
//    }
//
//    public function getCode(): ?string
//    {
//        return $this->code;
//    }
//
//    public function setCode(string $code): self
//    {
//        $this->code = $code;
//
//        return $this;
//    }
//
//    public function getPrefix(): ?string
//    {
//        return $this->prefix;
//    }
//
//    public function setPrefix(string $prefix): self
//    {
//        $this->prefix = $prefix;
//
//        return $this;
//    }
//
//    public function isDefault(): bool
//    {
//        return $this->default;
//    }
//
//    public function setDefault(bool $default): self
//    {
//        $this->default = $default;
//
//        return $this;
//    }
//
//    public function isActive(): bool
//    {
//        return $this->active;
//    }
//
//    public function setActive(bool $active): self
//    {
//        $this->active = $active;
//
//        return $this;
//    }
//
//    public function getCountryCode(): string
//    {
//        return strtolower(substr($this->code, -2));
//    }
//
//    public function getLanguageCode(): string
//    {
//        return strtolower(substr($this->code, 0, 2));
//    }
//}
