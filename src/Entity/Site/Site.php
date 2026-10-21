<?php

declare(strict_types=1);

namespace App\Entity\Site;

use App\Entity\AbstractEntity;
use App\Entity\Banner;
use App\Entity\Brand;
use App\Entity\Contact;
use App\Entity\EmailTemplate;
use App\Entity\Faq\FaqGroup;
use App\Entity\GalleryImage;
use App\Entity\GenericName;
use App\Entity\MailLog;
use App\Entity\Page\Page;
use App\Entity\Review\Review;
use App\Entity\Traits\ActiveEntityTrait;
use App\Entity\Traits\Site\SiteDomainDetailsTrait;
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
#[ORM\Index(name: 'fk_site_theme_id', columns: ['site_theme_id'])]
#[ORM\UniqueConstraint(name: 'uniq_domain', columns: ['domain'])]
#[ORM\UniqueConstraint(name: 'uniq_token', columns: ['token'])]
#[ORM\Index(name: 'idx_registrar_email', columns: ['registrar_email'])]
#[ORM\Index(name: 'idx_registered_at', columns: ['registered_at'])]
#[ORM\Index(name: 'idx_expire_at', columns: ['expire_at'])]
#[ORM\Index(name: 'idx_is_penalty', columns: ['is_penalty'])]
#[ORM\Entity(repositoryClass: SiteRepository::class)]
class Site extends AbstractEntity
{
    use ActiveEntityTrait;
    use TitleEntityTrait;
    use SiteDomainRegistrationTrait;
    use SiteDomainDetailsTrait;

    #[ORM\Column(name: 'domain', type: Types::STRING, length: 255, unique: true, nullable: false)]
    private ?string $domain = null;

    #[ORM\Column(name: 'token', type: Types::STRING, length: 40, nullable: true)]
    private ?string $token = null;

    #[ORM\ManyToMany(targetEntity: GenericName::class, mappedBy: 'sites')]
    private Collection $genericNames;

    #[ORM\ManyToMany(targetEntity: Brand::class, mappedBy: 'sites')]
    private Collection $brands;

    #[ORM\Column(name: 'footer_text1', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $footerText1 = null;

    #[ORM\Column(name: 'footer_text2', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $footerText2 = null;

    #[ORM\Column(name: 'copyright_text', type: Types::TEXT, length: 65535, nullable: true)]
    private ?string $copyrightText = null;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $pages;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'sites')]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: SiteTheme::class, inversedBy: 'sites')]
    #[ORM\JoinColumn(name: 'site_theme_id', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?SiteTheme $siteTheme = null;

    #[ORM\OneToMany(targetEntity: GalleryImage::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $galleryImages;

    #[ORM\OneToMany(targetEntity: FaqGroup::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $faqGroups;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $contacts;

    #[ORM\OneToOne(targetEntity: SiteSettings::class, mappedBy: 'site', cascade: ['persist'])]
    private ?SiteSettings $settings = null;

    #[ORM\OneToMany(targetEntity: MailLog::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $mailLogs;

    #[ORM\OneToMany(targetEntity: Banner::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $banners;

    #[ORM\OneToMany(targetEntity: EmailTemplate::class, mappedBy: 'site', orphanRemoval: true)]
    private Collection $emailTemplates;

    public function __construct()
    {
        parent::__construct();

        $this->pages          = new ArrayCollection();
        $this->users          = new ArrayCollection();
        $this->reviews        = new ArrayCollection();
        $this->galleryImages  = new ArrayCollection();
        $this->faqGroups      = new ArrayCollection();
        $this->genericNames   = new ArrayCollection();
        $this->brands         = new ArrayCollection();
        $this->contacts       = new ArrayCollection();
        $this->mailLogs       = new ArrayCollection();
        $this->banners        = new ArrayCollection();
        $this->emailTemplates = new ArrayCollection();
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

    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getFooterText1(): ?string
    {
        return $this->footerText1;
    }

    public function setFooterText1(?string $footerText1): self
    {
        $this->footerText1 = $footerText1;

        return $this;
    }

    public function getFooterText2(): ?string
    {
        return $this->footerText2;
    }

    public function setFooterText2(?string $footerText2): self
    {
        $this->footerText2 = $footerText2;

        return $this;
    }

    public function getCopyrightText(): ?string
    {
        return $this->copyrightText;
    }

    public function setCopyrightText(?string $copyrightText): self
    {
        $this->copyrightText = $copyrightText;

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

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addSite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setSite($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getSite() === $this) {
                $review->setSite(null);
            }
        }

        return $this;
    }

    public function getSiteTheme(): ?SiteTheme
    {
        return $this->siteTheme;
    }

    public function setSiteTheme(?SiteTheme $siteTheme): self
    {
        $this->siteTheme = $siteTheme;

        return $this;
    }

    /**
     * @return Collection<int, GalleryImage>
     */
    public function getGalleryImages(): Collection
    {
        return $this->galleryImages;
    }

    public function addGalleryImage(GalleryImage $galleryImage): static
    {
        if (!$this->galleryImages->contains($galleryImage)) {
            $this->galleryImages->add($galleryImage);
            $galleryImage->setSite($this);
        }

        return $this;
    }

    public function removeGalleryImage(GalleryImage $galleryImage): static
    {
        if ($this->galleryImages->removeElement($galleryImage)) {
            // set the owning side to null (unless already changed)
            if ($galleryImage->getSite() === $this) {
                $galleryImage->setSite(null);
            }
        }

        return $this;
    }

    public function getFaqGroups(): Collection
    {
        return $this->faqGroups;
    }

    public function addFaqGroup(FaqGroup $faqGroup): static
    {
        if (!$this->faqGroups->contains($faqGroup)) {
            $this->faqGroups->add($faqGroup);
            $faqGroup->setSite($this);
        }

        return $this;
    }

    public function removeFaqGroup(FaqGroup $fagGroup): static
    {
        if ($this->faqGroups->removeElement($fagGroup)) {
            // set the owning side to null (unless already changed)
            if ($fagGroup->getSite() === $this) {
                $fagGroup->setSite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GenericName>
     */
    public function getGenericNames(): Collection
    {
        return $this->genericNames;
    }

    public function addGenericName(GenericName $genericName): static
    {
        if (!$this->genericNames->contains($genericName)) {
            $this->genericNames->add($genericName);
            $genericName->addSite($this);
        }

        return $this;
    }

    public function removeGenericName(GenericName $genericName): static
    {
        if ($this->genericNames->removeElement($genericName)) {
            $genericName->removeSite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Brand>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brand $brand): static
    {
        if (!$this->brands->contains($brand)) {
            $this->brands->add($brand);
            $brand->addSite($this);
        }

        return $this;
    }

    public function removeBrand(Brand $brand): static
    {
        if ($this->brands->removeElement($brand)) {
            $brand->removeSite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setSite($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getSite() === $this) {
                $contact->setSite(null);
            }
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
     * @return Collection<int, MailLog>
     */
    public function getMailLogs(): Collection
    {
        return $this->mailLogs;
    }

    public function addMailLog(MailLog $mailLog): static
    {
        if (!$this->mailLogs->contains($mailLog)) {
            $this->mailLogs->add($mailLog);
            $mailLog->setSite($this);
        }

        return $this;
    }

    public function removeMailLog(MailLog $mailLog): static
    {
        if ($this->mailLogs->removeElement($mailLog)) {
            // set the owning side to null (unless already changed)
            if ($mailLog->getSite() === $this) {
                $mailLog->setSite(null);
            }
        }

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
     * @return Collection<int, EmailTemplate>
     */
    public function getEmailTemplates(): Collection
    {
        return $this->emailTemplates;
    }

    public function addEmailTemplate(EmailTemplate $emailTemplate): static
    {
        if (!$this->emailTemplates->contains($emailTemplate)) {
            $this->emailTemplates->add($emailTemplate);
            $emailTemplate->setSite($this);
        }

        return $this;
    }

    public function removeEmailTemplate(EmailTemplate $emailTemplate): static
    {
        if ($this->emailTemplates->removeElement($emailTemplate)) {
            // set the owning side to null (unless already changed)
            if ($emailTemplate->getSite() === $this) {
                $emailTemplate->setSite(null);
            }
        }

        return $this;
    }
}
