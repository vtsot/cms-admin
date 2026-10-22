<?php

declare(strict_types=1);

namespace App\Service\CmsEmbed;

use App\CQ\Query\Faq\GetFaqGroupBySiteTokenAndSiteIdCollectionQuery;
use App\DTO\Collection\Faq\FaqGroupCollectionDTO;
use App\Repository\Site\SiteRepository;
use App\Service\MessageBusHandler;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RequestStack;

use function array_multisort;

use const SORT_ASC;
use const SORT_STRING;

class FaqGroupCmsEmbed extends AbstractCmsEmbed
{
    public const ID    = 'faq-group';
    public const LABEL = 'FAQs';
    public const HELP  = '';

    public function __construct(
        private readonly MessageBusHandler $messageBusHandler,
        private readonly RequestStack $requestStack,
        private readonly SiteRepository $siteRepository,
    ) {
    }

    public function getParams(): array
    {
        $items  = [];
        $labels = [];

        if ($siteId = $this->requestStack->getMainRequest()?->get('site')) {
            $siteId = Uuid::fromString($siteId);

            if ($siteToken = $this->siteRepository->findOneById($siteId)?->getToken()) {
                /* @var FaqGroupCollectionDTO $collection */
                $collection = $this->messageBusHandler->handleQuery(new GetFaqGroupBySiteTokenAndSiteIdCollectionQuery($siteToken, $siteId));

                foreach ($collection->items as $faqGroupDTO) {
                    $items[]  = [$faqGroupDTO->title, (string) $faqGroupDTO->id];
                    $labels[] = $faqGroupDTO->title;
                }

                // sort by label
                array_multisort($labels, SORT_STRING, SORT_ASC, $items);
            }
        }

        return [
            [
                'id'           => 'faq-group-id',
                'type'         => 'select',
                'label'        => static::LABEL,
                'default'      => null,
                'replace_help' => true, // custom parameter: show selected value as help
                'items'        => $items,
            ],
        ];
    }

    public function render(array $params = []): ?string
    {
        // nothing to display, required parameter not found
        if (empty($params['faq-group-id']) || !Uuid::isValid($params['faq-group-id'])
        ) {
            return null;
        }

        $template = $this->resolveRenderTemplate();

        return $this->twig->render($template, [
            'id' => $params['faq-group-id'],
        ]);
    }
}
