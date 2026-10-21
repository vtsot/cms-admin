<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\ApiRequest\SiteReview\CreateSiteReviewRequest;
use App\ApiRequest\SiteReview\GetSiteReviewCollectionRequest;
use App\ApiRequest\SiteReview\GetSiteReviewStatisticsRequest;
use App\Contract\Dictionary\ApiDocTag;
use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\Contract\Dictionary\Review\ReviewRateType;
use App\Contract\Dictionary\Review\ReviewSortType;
use App\CQ\Command\Site\CreateSiteReviewCommand;
use App\CQ\Command\Site\UpdateSiteReviewFeedbackCommand;
use App\CQ\Query\Site\GetSiteReviewCollectionQuery;
use App\CQ\Query\Site\GetSiteReviewStatisticsQuery;
use App\DTO\Collection\ReviewCollectionDTO;
use App\DTO\Data\ReviewStatistics\ReviewStatisticsDTO;
use App\DTO\Entity\Review\ReviewDTO;
use App\Service\MessageBusHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\EnumRequirement;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(
    path: '/api/sites/{siteId}/reviews',
    requirements: ['siteId' => Requirement::UUID]
)]
class SiteReviewController extends AbstractController
{
    #[Route(
        path: '',
        name: 'api.site.review.collection',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Parameter(ref: '#/components/parameters/query')]
    #[OA\Parameter(ref: '#/components/parameters/page')]
    #[OA\Parameter(ref: '#/components/parameters/per_page')]
    #[OA\Parameter(name: 'reason_id', in: 'query', required: false, schema: new OA\Schema(type: ['string', null], default: null))]
    #[OA\Parameter(name: 'sort', in: 'query', schema: new OA\Schema(ref: new Model(type: ReviewSortType::class)))]
    #[OA\Response(
        response: 200,
        description: 'Return site review collection',
        content: new OA\JsonContent(
            ref: new Model(
                type: ReviewCollectionDTO::class,
                groups: [
                    'review_collection',
                    'collection_meta',
                    'age_review_question_item_collection',
                    'medication_time_review_question_item_collection',
                    'reason_review_question_item_collection',
                ],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function collection(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        GetSiteReviewCollectionRequest $request,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var ReviewCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSiteReviewCollectionQuery(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
                query: $request->query,
                page: $request->page,
                perPage: $request->perPage,
                reasonId: $request->reasonId ? Uuid::fromString($request->reasonId) : null,
                sortType: ReviewSortType::from($request->sort),
            )
        );

        return $this->json(
            data: $dto,
            context: [
                'groups' => [
                    'review_collection',
                    'collection_meta',
                    'age_review_question_item_collection',
                    'medication_time_review_question_item_collection',
                    'reason_review_question_item_collection',
                ],
            ]
        );
    }

    #[Route(
        path: '',
        name: 'api.site.review.post',
        options: ['expose' => true],
        methods: ['POST']
    )]
    #[OA\RequestBody(content: new OA\JsonContent(ref: new Model(type: CreateSiteReviewRequest::class)))]
    #[OA\Response(
        response: 200,
        description: 'Return review details',
        content: new OA\JsonContent(
            ref: new Model(
                type: ReviewDTO::class,
                groups: [
                    'review_details',
                    'age_review_question_item_details',
                    'medication_time_review_question_item_details',
                    'reason_review_question_item_details',
                ],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function post(
        string $siteId,
        CreateSiteReviewRequest $request,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var ReviewDTO $dto */
        $dto = $messageBusHandler->handleCommand(
            new CreateSiteReviewCommand(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
                reasonId: Uuid::fromString($request->reasonId),
                authorName: $request->authorName,
                authorGender: ReviewAuthorGender::from($request->authorGender),
                authorType: ReviewAuthorType::from($request->authorType),
                authorAgeId: Uuid::fromString($request->authorAgeId),
                medicationTimeId: Uuid::fromString($request->medicationTimeId),
                effectiveness: $request->effectiveness,
                easeOfUse: $request->easeOfUse,
                satisfaction: $request->satisfaction,
                content: $request->content,
                fullName: $request->fullName,
                email: $request->email,
                productId: $request->productId ? Uuid::fromString($request->productId) : null,
                otherProductName: $request->otherProductName,
                otherProductManufacturer: $request->otherProductManufacturer,
            )
        );

        return $this->json(
            data: $dto,
            context: [
                'groups' => [
                    'review_details',
                    'age_review_question_item_details',
                    'medication_time_review_question_item_details',
                    'reason_review_question_item_details',
                ],
            ]
        );
    }

    #[Route(
        path: '/{reviewId}/rate/{type}',
        name: 'api.site.review.rate',
        requirements: [
            'reviewId' => Requirement::UUID,
            'type'     => new EnumRequirement(ReviewRateType::class),
        ],
        options: ['expose' => true],
        methods: ['PUT'],
    )]
    #[OA\Response(response: 204, description: 'No content on success')]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function rate(
        string $siteId,
        string $reviewId,
        string $type,
        MessageBusHandler $messageBusHandler,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        $messageBusHandler->handleCommand(
            new UpdateSiteReviewFeedbackCommand(
                $user->getUserIdentifier(),
                Uuid::fromString($siteId),
                Uuid::fromString($reviewId),
                ReviewRateType::from($type)
            )
        );

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(
        path: '/statistics',
        name: 'api.site.review.statistics',
        options: ['expose' => true],
        methods: ['GET']
    )]
    #[OA\Parameter(ref: '#/components/parameters/query')]
    #[OA\Parameter(name: 'reason_id', in: 'query', required: false, schema: new OA\Schema(type: ['string', null], default: null))]
    #[OA\Response(
        response: 200,
        description: 'Return site review statistics',
        content: new OA\JsonContent(
            ref: new Model(
                type: ReviewStatisticsDTO::class,
                groups: [
                    'review_statistics',
                    'review_collection',
                    'review_details',
                    'collection_meta',
                    'reason_review_question_item_collection',
                    'age_review_question_item_collection',
                    'medication_time_review_question_item_collection',
                ],
            )
        )
    )]
    #[OA\Response(ref: '#/components/responses/invalid_json', response: '400')]
    #[OA\Response(ref: '#/components/responses/unauthorized', response: '401')]
    #[OA\Response(ref: '#/components/responses/forbidden', response: '403')]
    #[OA\Response(ref: '#/components/responses/not_found', response: '404')]
    #[OA\Response(ref: '#/components/responses/error', response: '422')]
    #[OA\Tag(name: ApiDocTag::SITES)]
    public function statistics(
        string $siteId,
        MessageBusHandler $messageBusHandler,
        GetSiteReviewStatisticsRequest $request,
        #[CurrentUser] UserInterface $user,
    ): JsonResponse {
        /** @var ReviewCollectionDTO $dto */
        $dto = $messageBusHandler->handleQuery(
            new GetSiteReviewStatisticsQuery(
                siteToken: $user->getUserIdentifier(),
                siteId: Uuid::fromString($siteId),
                query: $request->query,
                reasonId: $request->reasonId ? Uuid::fromString($request->reasonId) : null,
            )
        );

        return $this->json(
            data: $dto,
            context: [
                'groups' => [
                    'review_statistics',
                    'review_collection',
                    'review_details',
                    'collection_meta',
                    'reason_review_question_item_collection',
                    'age_review_question_item_collection',
                    'medication_time_review_question_item_collection',
                ],
            ]
        );
    }
}
