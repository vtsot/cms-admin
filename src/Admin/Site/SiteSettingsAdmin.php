<?php

declare(strict_types=1);

namespace App\Admin\Site;

use App\Admin\AbstractAdmin;
use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Entity\Site\SiteSettings;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Component\Validator\Constraints\Email;

/**
 * @method SiteSettings|null getSubject()
 */
class SiteSettingsAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection->remove('create');
        $collection->remove('delete');
    }

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'ASC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldCreatedAtDateRange($filter);
        $this->configureFilterFieldUpdatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldChangedAt($list);
        $this->configureListFieldActions($list);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $this->configureFormSectionSender($form);
    }

    private function configureFormSectionSender(FormMapper $form): void
    {
        $title = $this->transLocaleTitle('SITE_SETTINGS_ENTITY.SECTION.SENDER');
        $form->with($title, ['label' => $title]);

        $this->configureFormFieldText(
            $form,
            'senderEmail',
            'SITE_SETTINGS_ENTITY.LABEL.SENDER_EMAIL',
            'SITE_SETTINGS_ENTITY.HELP.SENDER_EMAIL',
            false,
            ['constraints' => [new Email()]],
        );

        $this->configureFormFieldText(
            $form,
            'senderName',
            'SITE_SETTINGS_ENTITY.LABEL.SENDER_NAME',
            'SITE_SETTINGS_ENTITY.HELP.SENDER_NAME',
            false,
            ['constraints' => []],
        );

        $this->configureFormFieldText(
            $form,
            'fromEmail',
            'SITE_SETTINGS_ENTITY.LABEL.FROM_EMAIL',
            'SITE_SETTINGS_ENTITY.HELP.FROM_EMAIL',
        );

        $this->configureFormFieldText(
            $form,
            'fromName',
            'SITE_SETTINGS_ENTITY.LABEL.FROM_NAME',
            'SITE_SETTINGS_ENTITY.HELP.FROM_NAME',
        );

        $form->end();
    }
}
