<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MailLog;
use App\Security\Voter\Admin\MailLogVoter;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Service\Attribute\Required;

use function preg_replace;

class MailLogCrudController extends AbstractCrudController
{
    protected Security $security;

    #[Required]
    public function init(
        Security $security,
    ): void {
        $this->security = $security;
    }

    public function showHtmlAction(
        Request $request,
    ): Response {
        /** @var MailLog $mailLog */
        $mailLog = $this->assertObjectExists($request, true);

        if (!$mailLog) {
            throw $this->createNotFoundException();
        }

        return new Response($mailLog->getHtml());
    }

    public function showTextAction(
        Request $request,
    ): Response {
        /** @var MailLog $mailLog */
        $mailLog = $this->assertObjectExists($request, true);

        if (!$mailLog) {
            throw $this->createNotFoundException();
        }

        // remove none printable symbols
        // remove repeated line breaks
        $text = preg_replace('/[^[:print:]\r\n]/', '', (string) $mailLog->getText());
        $text = preg_replace('/(\r\n|\r|\n)+/', "\n", $text);

        return new Response($text, 200, ['Content-Type' => 'text/plain']);
    }

    protected function handlePreActionAccess(
        string $attribute,
        mixed $subject,
    ): ?Response {
        if (!$this->security->isGranted($attribute, $subject)) {
            $this->addErrorFlash('FLASH.ERROR.NO_PERMISSION');

            return $this->redirectToList();
        }

        return null;
    }

    protected function preList(Request $request): ?Response
    {
        return $this->handlePreActionAccess(MailLogVoter::LIST, MailLog::class);
    }

    protected function preShow(Request $request, object $object): ?Response
    {
        return $this->handlePreActionAccess(MailLogVoter::VIEW, $object);
    }

    protected function preCreate(Request $request, object $object): ?Response
    {
        return $this->handlePreActionAccess(MailLogVoter::CREATE, MailLog::class);
    }

    protected function preEdit(Request $request, object $object): ?Response
    {
        return $this->handlePreActionAccess(MailLogVoter::UPDATE, $object);
    }

    protected function preDelete(Request $request, object $object): ?Response
    {
        return $this->handlePreActionAccess(MailLogVoter::DELETE, $object);
    }
}
