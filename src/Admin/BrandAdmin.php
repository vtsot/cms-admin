<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteUsersTrait;
use App\Admin\Traits\ConfigureFormAutocompleteUsersTrait;
use App\Entity\Brand;
use App\Repository\BrandRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method Brand|null getSubject()
 */
class BrandAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteUsersTrait;
    use ConfigureFormAutocompleteUsersTrait;

    protected BrandRepository $brandRepository;

    #[Required]
    public function initDependencies(
        BrandRepository $brandRepository,
    ): void {
        $this->brandRepository = $brandRepository;
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'name',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'name', 'BRAND_ENTITY.LABEL.NAME');
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'name', 'BRAND_ENTITY.LABEL.NAME');

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('BRAND_ENTITY.SECTION.MAIN');

        $form->add(
            'name',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'BRAND_ENTITY.LABEL.NAME',
                'help'        => 'BRAND_ENTITY.HELP.NAME',
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateFormFieldBrandName']),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->end();
    }

    public function validateFormFieldBrandName(?string $value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $entity = $this->brandRepository->findOneByName($value);

        if ($entity !== null
            && $this->getSubject() !== null
            && $entity->getId() !== $this->getSubject()->getId()
        ) {
            $context
                ->buildViolation('BRAND_ENTITY.ERROR.NAME_TAKEN')
                ->setParameter('%NAME%', $value)
                ->setTranslationDomain($this->getTranslationDomain())
                ->atPath('name')->addViolation();
        }
    }
}
