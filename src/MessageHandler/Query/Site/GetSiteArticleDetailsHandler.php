<?php

declare(strict_types=1);

namespace App\MessageHandler\Query\Site;

use App\Contract\MessageHandler\QueryHandlerInterface;
use App\DTO\Entity\Page\ArticleDetailsDTO;
use App\DTOFactory\Entity\Page\ArticleDetailsDTOFactory;
use App\Entity\Page\Article;
use App\Exception\Security\AccessDeniedException;
use App\Exception\Validation\EntityNotFoundException;
use App\Message\Query\Site\GetSiteArticleDetailsQuery;
use App\Repository\Page\ArticleRepository;
use App\Security\Voter\ApiSite\PageVoter;
use App\Security\Voter\VoterSubject;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class GetSiteArticleDetailsHandler implements QueryHandlerInterface
{
    public function __construct(
        private Security $security,
        private TranslatorInterface $translator,
        private ArticleRepository $articleRepository,
        private ArticleDetailsDTOFactory $articleDetailsDTOFactory,
    ) {
    }

    public function __invoke(GetSiteArticleDetailsQuery $query): ArticleDetailsDTO
    {
        $siteId = $query->user->siteId;
        $token  = $query->user->token;

        /** @var Article $article */
        if (!$article = $this->articleRepository->findOneActiveBySiteIdAndTokenAndSlug($siteId, $token, $query->slug)) {
            throw new EntityNotFoundException($this->translator->trans(id: 'ARTICLE.NOT_FOUND', domain: 'validators'));
        }

        if (!$this->security->isGranted(PageVoter::VIEW, new VoterSubject($siteId, $article))) {
            throw new AccessDeniedException($this->translator->trans(id: 'SECURITY.ACCESS_DENIED', domain: 'security'));
        }

        return $this->articleDetailsDTOFactory->fromEntity($article);
    }
}
