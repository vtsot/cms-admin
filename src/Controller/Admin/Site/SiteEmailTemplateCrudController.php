<?php

declare(strict_types=1);

namespace App\Controller\Admin\Site;

use App\CQ\Command\Site\CreateDefaultSiteEmailTemplatesCommand;
use App\Entity\EmailTemplate;
use App\Security\Voter\Admin\SiteEmailTemplateVoter;
use App\Service\MessageBusHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SiteEmailTemplateCrudController extends AbstractSiteRootCrudController
{
    public function __construct(
        private readonly MessageBusHandler $messageBusHandler,
    ) {
    }

    public function showHtmlAction(Request $request): Response
    {
        $site   = $this->resolveSiteFromRootRequest($request);
        $object = $this->assertObjectExists($request, true);

        if ($response = $this->handlePreActionAccess(
            SiteEmailTemplateVoter::VIEW,
            [$site, $object])
        ) {
            return $response;
        }

        return new Response($object?->getHtml() ?? '');
    }

    public function showTextAction(Request $request): Response
    {
        $site   = $this->resolveSiteFromRootRequest($request);
        $object = $this->assertObjectExists($request, true);

        if ($response = $this->handlePreActionAccess(
            SiteEmailTemplateVoter::VIEW,
            [$site, $object])
        ) {
            return $response;
        }

        // remove none printable symbols
        // remove repeated line breaks
        $text = preg_replace('/[^[:print:]\r\n]/', '', (string) $object?->getText());
        $text = preg_replace('/(\r\n|\r|\n)+/', "\n", $text);

        return new Response($text, 200, ['Content-Type' => 'text/plain']);
    }

    protected function preList(Request $request): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        if ($response = $this->handlePreActionAccess(
            SiteEmailTemplateVoter::LIST,
            [$site, EmailTemplate::class])
        ) {
            return $response;
        }

        if ($site->getEmailTemplates()->isEmpty()) {
            $this->messageBusHandler->handleCommand(new CreateDefaultSiteEmailTemplatesCommand($site->getId()));

            return $this->redirectToList();
        }

        return null;
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteEmailTemplateVoter::VIEW,
            [$site, $object],
        );
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteEmailTemplateVoter::CREATE,
            [$site, EmailTemplate::class],
        );
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteEmailTemplateVoter::UPDATE,
            [$site, $object],
        );
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        $site = $this->resolveSiteFromRootRequest($request);

        return $this->handlePreActionAccess(
            SiteEmailTemplateVoter::DELETE,
            [$site, $object],
        );
    }
}
