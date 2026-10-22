<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\Entity\Site\SiteSettings;
use App\Security\Voter\Admin\Site\SiteSettingsVoter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteSettingsCrudController extends AbstractSiteRootCrudController
{
    protected function redirectTo(Request $request, object $object): RedirectResponse
    {
        if ($request->request->get('btn_update_and_list') !== null) {
            return $this->redirectToRoute('admin.site_list');
        }

        return parent::redirectTo($request, $object);
    }

    protected function preList(Request $request): ?Response
    {
        $site     = $this->resolveSiteFromRootRequest($request);
        $response = $this->handlePreActionAccess(
            SiteSettingsVoter::LIST,
            [$site, SiteSettings::class],
        );

        return $response
            ?? $this->redirectToRoute('admin.site_settings', ['id' => $site->getId()?->toString()]);
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteSettingsVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteSettingsVoter::CREATE,
            [$site, SiteSettings::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteSettingsVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteSettingsVoter::DELETE,
            [$site, $object],
        );
    }
}
