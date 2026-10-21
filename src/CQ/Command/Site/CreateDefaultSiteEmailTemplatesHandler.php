<?php

declare(strict_types=1);

namespace App\CQ\Command\Site;

use App\Contract\MessageHandler\CommandHandlerInterface;
use App\Entity\EmailTemplate;
use App\Exception\Validation\EntityNotFoundException;
use App\Repository\Site\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use function array_map;
use function array_unique;
use function array_values;
use function in_array;

readonly class CreateDefaultSiteEmailTemplatesHandler implements CommandHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private TranslatorInterface $translator,
        private SiteRepository $siteRepository,
    ) {
    }

    public function __invoke(CreateDefaultSiteEmailTemplatesCommand $command): void
    {
        $site = $this->siteRepository->findOneById($command->siteId);

        if ($site === null) {
            throw new EntityNotFoundException($this->translator->trans('SITE.NOT_FOUND'));
        }

        $codes = [
            EmailTemplate::CODE_CONTACT                   => ['active' => false],
            EmailTemplate::CODE_EXPIRATION_4_WEEKS_BEFORE => ['active' => true],
            EmailTemplate::CODE_EXPIRATION_2_WEEKS_BEFORE => ['active' => true],
            EmailTemplate::CODE_EXPIRATION_1_DAY_BEFORE   => ['active' => true],
        ];

        $savedCodes = array_values(array_unique(array_map(
            static fn (EmailTemplate $emailTemplate) => $emailTemplate->getCode(),
            $site->getEmailTemplates()->toArray()
        )));

        $isFlush = false;

        foreach ($codes as $code => $data) {
            if (!in_array($code, $savedCodes, true)) {
                $emailTemplate = (new EmailTemplate())
                    ->setCode($code)
                    ->setSite($site)
                    ->setActive($data['active']);

                $isFlush = true;
                $this->em->persist($emailTemplate);
            }
        }

        if ($isFlush) {
            $this->em->flush();
        }
    }
}
