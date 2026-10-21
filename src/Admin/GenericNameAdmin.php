<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteUsersTrait;
use App\Admin\Traits\ConfigureFormAutocompleteUsersTrait;
use App\Entity\GenericName;
use App\Repository\GenericNameRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * @method GenericName|null getSubject()
 */
class GenericNameAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteUsersTrait;
    use ConfigureFormAutocompleteUsersTrait;

    protected GenericNameRepository $genericNameRepository;

    #[Required]
    public function initDependencies(
        GenericNameRepository $genericNameRepository,
    ): void {
        $this->genericNameRepository = $genericNameRepository;
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
        $this->configureFilterFieldText($filter, 'name', 'GENERIC_NAME_ENTITY.LABEL.NAME');

        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'name', 'GENERIC_NAME_ENTITY.LABEL.NAME');

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('GENERIC_NAME_ENTITY.SECTION.MAIN');

        $form->add(
            'name',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'GENERIC_NAME_ENTITY.LABEL.NAME',
                'help'        => 'GENERIC_NAME_ENTITY.HELP.NAME',
                'constraints' => [
                    new NotBlank(),
                    new Callback([$this, 'validateFormFieldGenericName']),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->end();
    }

    public function validateFormFieldGenericName(?string $value, ExecutionContextInterface $context): void
    {
        if ($value === null) {
            return;
        }

        $entity = $this->genericNameRepository->findOneByName($value);

        if ($entity !== null
            && $this->getSubject() !== null
            && $entity->getId() !== $this->getSubject()->getId()
        ) {
            $context
                ->buildViolation('GENERIC_NAME_ENTITY.ERROR.NAME_TAKEN')
                ->setParameter('%NAME%', $value)
                ->setTranslationDomain($this->getTranslationDomain())
                ->atPath('name')->addViolation();
        }
    }
}
