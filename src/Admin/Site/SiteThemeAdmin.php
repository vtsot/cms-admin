<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Site\SiteTheme;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method SiteTheme|null getSubject()
 */
class SiteThemeAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'title',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldText($filter, 'title', 'SITE_THEME_ENTITY.LABEL.TITLE');

        $this->configureFilterFieldActive($filter);
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText($list, 'title', 'SITE_THEME_ENTITY.LABEL.TITLE');

        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form->with('SITE_THEME_ENTITY.SECTION.MAIN');

        $form->add(
            'title',
            TextType::class,
            [
                'required'    => true,
                'label'       => 'SITE_THEME_ENTITY.LABEL.TITLE',
                'help'        => 'SITE_THEME_ENTITY.HELP.TITLE',
                'constraints' => [
                    new NotBlank(),
                ],
                'translation_domain' => $this->getTranslationDomain(),
            ]
        );

        $form->end();
    }
}
