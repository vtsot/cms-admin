<?php

declare(strict_types=1);

namespace App\Admin\Review;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Contract\Dictionary\Review\ReviewAuthorGender;
use App\Contract\Dictionary\Review\ReviewAuthorType;
use App\Contract\Dictionary\Review\ReviewQuestionType;
use App\Entity\Review\Review;
use App\Repository\Review\ReviewQuestionItemRepository;
use Carbon\CarbonImmutable;
use JetBrains\PhpStorm\ArrayShape;
use Ramsey\Uuid\Uuid;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method Review|null getSubject()
 */
class ReviewAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    private ReviewQuestionItemRepository $reviewQuestionItemRepository;

    #[Required]
    public function initDependencies(
        ReviewQuestionItemRepository $reviewQuestionItemRepository,
    ): void {
        $this->reviewQuestionItemRepository = $reviewQuestionItemRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'authorName', 'REVIEW_ENTITY.LABEL.AUTHOR.NAME');
        $this->configureFilterFieldChoice(
            $filter,
            'authorAge',
            $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Age),
            'REVIEW_ENTITY.LABEL.AUTHOR.AGE',
        );
        $this->configureFilterFieldChoice(
            $filter,
            'authorGender',
            $this->getAuthorGenderChoices(),
            'REVIEW_ENTITY.LABEL.AUTHOR.GENDER',
        );
        $this->configureFilterFieldChoice(
            $filter,
            'authorType',
            $this->getAuthorTypeChoices(),
            'REVIEW_ENTITY.LABEL.AUTHOR.TYPE',
        );

        $this->configureFilterFieldChoice(
            $filter,
            'reason',
            $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Reason),
            'REVIEW_ENTITY.LABEL.REASON',
        );
        $this->configureFilterFieldText($filter, 'content', 'REVIEW_ENTITY.LABEL.CONTENT');
        $this->configureFilterFieldChoice(
            $filter,
            'medicationTime',
            $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::MedicationTime),
            'REVIEW_ENTITY.LABEL.MEDICATION_TIME',
        );

        $this->configureFilterFieldNumber($filter, 'effectiveness', 'REVIEW_ENTITY.LABEL.EFFECTIVENESS');
        $this->configureFilterFieldNumber($filter, 'easeOfUse', 'REVIEW_ENTITY.LABEL.EASE_OF_USE');
        $this->configureFilterFieldNumber($filter, 'satisfaction', 'REVIEW_ENTITY.LABEL.SATISFACTION');

        $this->configureFilterFieldNumber($filter, 'likeQuantity', 'REVIEW_ENTITY.LABEL.LIKE_QTY');
        $this->configureFilterFieldNumber($filter, 'dislikeQuantity', 'REVIEW_ENTITY.LABEL.DISLIKE_QTY');
        $this->configureFilterFieldNumber($filter, 'reportQuantity', 'REVIEW_ENTITY.LABEL.REPORT_QTY');

        $this->configureFilterFieldText($filter, 'fullName', 'REVIEW_ENTITY.LABEL.FULL_NAME');
        $this->configureFilterFieldText($filter, 'email', 'REVIEW_ENTITY.LABEL.EMAIL');

        $this->configureFilterFieldChoice(
            $filter,
            'product',
            $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Product),
            'REVIEW_ENTITY.LABEL.PRODUCT',
        );

        $this->configureFilterFieldText($filter, 'otherProductName', 'REVIEW_ENTITY.LABEL.OTHER_PRODUCT_NAME');
        $this->configureFilterFieldText($filter, 'otherProductManufacturer', 'REVIEW_ENTITY.LABEL.OTHER_PRODUCT_MANUFACTURER');

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    #[ArrayShape([
        'REVIEW_ENTITY.GENDER.MALE'   => 'string',
        'REVIEW_ENTITY.GENDER.FEMALE' => 'string',
    ])]
    protected function getAuthorGenderChoices(): array
    {
        return [
            'REVIEW_ENTITY.GENDER.MALE'   => ReviewAuthorGender::Male->value,
            'REVIEW_ENTITY.GENDER.FEMALE' => ReviewAuthorGender::Female->value,
        ];
    }

    #[ArrayShape([
        'REVIEW_ENTITY.TYPE.PATIENT'   => 'string',
        'REVIEW_ENTITY.TYPE.CAREGIVER' => 'string',
    ])]
    protected function getAuthorTypeChoices(): array
    {
        return [
            'REVIEW_ENTITY.TYPE.PATIENT'   => ReviewAuthorType::Patient->value,
            'REVIEW_ENTITY.TYPE.CAREGIVER' => ReviewAuthorType::Caregiver->value,
        ];
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText(
            $list,
            'author',
            'REVIEW_ENTITY.FIELD.AUTHOR',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/review/list__author.html.twig',
                'header_style'  => 'width:220px;',
            ]
        );

        $this->configureListFieldText(
            $list,
            'details',
            'REVIEW_ENTITY.FIELD.DETAILS',
            [
                'virtual_field' => true,
                'sortable'      => false,
                'template'      => 'admin/CRUD/review/list__details.html.twig',
                'header_style'  => 'width:250px;',
            ]
        );

        $this->configureListFieldHtml($list, 'content', 'REVIEW_ENTITY.LABEL.CONTENT');

        $options = ['header_style' => 'width:80px;'];
        $this->configureListFieldNumber($list, 'likeQuantity', 'REVIEW_ENTITY.LABEL.LIKE_QTY', $options);
        $this->configureListFieldNumber($list, 'dislikeQuantity', 'REVIEW_ENTITY.LABEL.DISLIKE_QTY', $options);
        $this->configureListFieldNumber($list, 'reportQuantity', 'REVIEW_ENTITY.LABEL.REPORT_QTY', $options);

        $this->configureListFieldActive($list);
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    private function getChoiceReviewQuestionItemsByType(ReviewQuestionType $type): array
    {
        $siteId = $this->getRequest()->get($this->getRootAncestor()->getIdParameter());

        return $siteId
            ? $this->reviewQuestionItemRepository->getChoiceListBySiteIdAndType(Uuid::fromString($siteId), $type)
            : [];
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormSectionCustomer($form);
        $this->configureFormSectionReview($form);
        $this->configureFormSectionProduct($form);
        $this->configureFormSectionFeedback($form);
    }

    private function configureFormSectionCustomer(FormMapper $form): void
    {
        $form->with('REVIEW_ENTITY.SECTION.CUSTOMER');
        $form->add(
            'authorName',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'REVIEW_ENTITY.LABEL.AUTHOR.NAME',
                'help'        => 'REVIEW_ENTITY.HELP.AUTHOR.NAME',
                'constraints' => [
                    new NotBlank(),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );

        $form->add(
            'fullName',
            TextType::class,
            [
                'required' => false,
                'label'    => 'REVIEW_ENTITY.LABEL.FULL_NAME',
                'help'     => 'REVIEW_ENTITY.HELP.FULL_NAME',
                // 'constraints' => [new NotBlank()],
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );

        $form->add(
            'email',
            TextType::class,
            [
                'required'           => false,
                'label'              => 'REVIEW_ENTITY.LABEL.EMAIL',
                'help'               => 'REVIEW_ENTITY.HELP.EMAIL',
                'constraints'        => [new Email()],
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );

        $form->add(
            'authorAge',
            ModelType::class,
            [
                'label'       => 'REVIEW_ENTITY.LABEL.AUTHOR.AGE',
                'help'        => 'REVIEW_ENTITY.HELP.AUTHOR.AGE',
                'placeholder' => 'REVIEW_ENTITY.PLACEHOLDER.AUTHOR.AGE',
                'required'    => true,
                'btn_add'     => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'choice_loader' => new CallbackChoiceLoader(
                    fn () => $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Age),
                ),
            ],
        );

        $this->configureFormFieldChoice(
            form: $form,
            name: 'authorGender',
            choices: $this->getAuthorGenderChoices(),
            label: 'REVIEW_ENTITY.LABEL.AUTHOR.GENDER',
            help: 'REVIEW_ENTITY.HELP.AUTHOR.GENDER',
            required: true,
            options: [
                'data'        => $this->getSubject()?->getAuthorGender()?->value,
                'placeholder' => 'REVIEW_ENTITY.PLACEHOLDER.AUTHOR.GENDER',
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $this->configureFormFieldChoice(
            form: $form,
            name: 'authorType',
            choices: $this->getAuthorTypeChoices(),
            label: 'REVIEW_ENTITY.LABEL.AUTHOR.TYPE',
            help: 'REVIEW_ENTITY.HELP.AUTHOR.TYPE',
            required: true,
            options: [
                'data'        => $this->getSubject()?->getAuthorType()?->value,
                'placeholder' => 'REVIEW_ENTITY.PLACEHOLDER.AUTHOR.TYPE',
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $form->end();
    }

    private function configureFormSectionReview(FormMapper $form): void
    {
        $form->with('REVIEW_ENTITY.SECTION.REVIEW');

        $form->add(
            'reason',
            ModelType::class,
            [
                'label'         => 'REVIEW_ENTITY.LABEL.REASON',
                'help'          => 'REVIEW_ENTITY.HELP.REASON',
                'placeholder'   => 'REVIEW_ENTITY.PLACEHOLDER.REASON',
                'required'      => true,
                'btn_add'       => false,
                'choice_loader' => new CallbackChoiceLoader(
                    fn () => $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Reason),
                ),
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $this->configureFormFieldTextarea(
            $form,
            'content',
            'REVIEW_ENTITY.LABEL.CONTENT',
            'REVIEW_ENTITY.HELP.CONTENT',
            false,
            3,
        );

        $numberOptions = [
            'attr'        => ['min' => 1, 'max' => 5, 'style' => 'width:230px;'],
            'constraints' => [
                new NotBlank(),
                new GreaterThanOrEqual(1),
                new LessThanOrEqual(5),
            ],
        ];

        $this->configureFormFieldInteger(
            $form,
            'effectiveness',
            'REVIEW_ENTITY.LABEL.EFFECTIVENESS',
            'REVIEW_ENTITY.HELP.EFFECTIVENESS',
            true,
            $numberOptions,
        );

        $this->configureFormFieldInteger(
            $form,
            'easeOfUse',
            'REVIEW_ENTITY.LABEL.EASE_OF_USE',
            'REVIEW_ENTITY.HELP.EASE_OF_USE',
            true,
            $numberOptions,
        );

        $this->configureFormFieldInteger(
            $form,
            'satisfaction',
            'REVIEW_ENTITY.LABEL.SATISFACTION',
            'REVIEW_ENTITY.HELP.SATISFACTION',
            true,
            $numberOptions,
        );

        $form->add(
            'medicationTime',
            ModelType::class,
            [
                'label'         => 'REVIEW_ENTITY.LABEL.MEDICATION_TIME',
                'help'          => 'REVIEW_ENTITY.HELP.MEDICATION_TIME',
                'placeholder'   => 'REVIEW_ENTITY.PLACEHOLDER.MEDICATION_TIME',
                'required'      => true,
                'btn_add'       => false,
                'choice_loader' => new CallbackChoiceLoader(
                    fn () => $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::MedicationTime)
                ),
                'constraints' => [
                    new NotBlank(),
                ],
            ],
        );

        $this->configureFormFieldDate(
            $form,
            'createdAt',
            'FIELD.CREATED_AT',
            '',
            true,
            [
                'data'        => $this->getSubject()?->getCreatedAt() ?? new CarbonImmutable(),
                'mapped'      => false,
                'constraints' => [new NotBlank(), new LessThanOrEqual(CarbonImmutable::now())],
                'attr'        => [
                    'style' => 'width:230px;',
                    'max'   => CarbonImmutable::today()->format('Y-m-d'),
                ],
            ]
        );

        $form->end();
    }

    private function configureFormSectionProduct(FormMapper $form): void
    {
        $form->with('REVIEW_ENTITY.SECTION.PRODUCT');

        $form->add(
            'product',
            ModelType::class,
            [
                'label'         => 'REVIEW_ENTITY.LABEL.PRODUCT',
                'help'          => 'REVIEW_ENTITY.HELP.PRODUCT',
                'placeholder'   => 'REVIEW_ENTITY.PLACEHOLDER.PRODUCT',
                'required'      => false,
                'btn_add'       => false,
                'choice_loader' => new CallbackChoiceLoader(
                    fn () => $this->getChoiceReviewQuestionItemsByType(ReviewQuestionType::Product)
                ),
                //                'constraints' => [new NotBlank(),],
            ],
        );

        $form->add(
            'otherProductName',
            TextType::class,
            [
                'required' => false,
                'label'    => 'REVIEW_ENTITY.LABEL.OTHER_PRODUCT_NAME',
                'help'     => 'REVIEW_ENTITY.HELP.OTHER_PRODUCT_NAME',
                //                'constraints'        => [new Email()],
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );

        $form->add(
            'otherProductManufacturer',
            TextType::class,
            [
                'required' => false,
                'label'    => 'REVIEW_ENTITY.LABEL.OTHER_PRODUCT_MANUFACTURER',
                'help'     => 'REVIEW_ENTITY.HELP.OTHER_PRODUCT_MANUFACTURER',
                //                'constraints'        => [new Email()],
                'translation_domain' => $this->getTranslationDomain(),
            ],
        );

        $form->end();
    }

    private function configureFormSectionFeedback(FormMapper $form): void
    {
        $form->with('REVIEW_ENTITY.SECTION.FEEDBACK');

        $numberOptions = [
            'attr'        => ['min' => 0, 'style' => 'width:230px;'],
            'constraints' => [
                new GreaterThanOrEqual(0),
            ],
        ];

        $this->configureFormFieldInteger(
            $form,
            'likeQuantity',
            'REVIEW_ENTITY.LABEL.LIKE_QTY',
            'REVIEW_ENTITY.HELP.LIKE_QTY',
            false,
            $numberOptions,
        );

        $this->configureFormFieldInteger(
            $form,
            'dislikeQuantity',
            'REVIEW_ENTITY.LABEL.DISLIKE_QTY',
            'REVIEW_ENTITY.HELP.DISLIKE_QTY',
            false,
            $numberOptions,
        );

        $this->configureFormFieldInteger(
            $form,
            'reportQuantity',
            'REVIEW_ENTITY.LABEL.REPORT_QTY',
            'REVIEW_ENTITY.HELP.REPORT_QTY',
            false,
            $numberOptions,
        );

        $form->end();
    }

    protected function prePersist(object $object): void
    {
        /** @var Review $object */
        $this->prepareCreatedAt($object);
    }

    protected function preUpdate(object $object): void
    {
        /** @var Review $object */
        $this->prepareCreatedAt($object);
    }

    private function prepareCreatedAt(Review $review): void
    {
        /** @var CarbonImmutable $createdAt */
        if ($this->hasSubject()
            && ($form = $this->getForm())
            && $form->has('createdAt')
            && ($createdAt = CarbonImmutable::instance($form->get('createdAt')->getData()))
            && ($review->getCreatedAt() === null || !$review->getCreatedAt()->isSameDay($createdAt))
        ) {
            $review->changeCreatedAtManual($createdAt);
        }
    }
}
