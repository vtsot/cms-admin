<?php

declare(strict_types=1);

namespace App\Admin;

use App\Admin\Traits\ConfigureAdminFullTrait;
use App\Admin\Traits\ConfigureFilterAutocompleteSitesTrait;
use App\Contract\Dictionary\MailStatus;
use App\Entity\MailLog;
use JetBrains\PhpStorm\ArrayShape;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @method MailLog|null getSubject()
 */
class MailLogAdmin extends AbstractAdmin
{
    use ConfigureAdminFullTrait;
    use ConfigureFilterAutocompleteSitesTrait;

    protected function configureDefaultSortValues(array &$sortValues): void
    {
        $sortValues = [
            '_sort_order' => 'DESC',
            '_sort_by'    => 'createdAt',
        ];
    }

    protected function getAccessMapping(): array
    {
        return [
            'show_html' => 'SHOW_HTML',
            'show_text' => 'SHOW_TEXT',
        ];
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        // parent::configureRoutes($collection);
        $collection->clearExcept(['show', 'list']);
        $collection->add('show_html', $this->getRouterIdParameter() . '/show-html');
        $collection->add('show_text', $this->getRouterIdParameter() . '/show-text');
    }

    #[ArrayShape([
        'MAIL_LOG_ENTITY.STATUS.SENT'  => 'string',
        'MAIL_LOG_ENTITY.STATUS.ERROR' => 'string',
    ])]
    protected function getStatusChoices(): array
    {
        return [
            // 'MAIL_LOG_ENTITY.STATUS.PENDING' => MailLog::STATUS_PENDING,
            'MAIL_LOG_ENTITY.STATUS.SENT'  => MailStatus::Sent->value,
            'MAIL_LOG_ENTITY.STATUS.ERROR' => MailStatus::Error->value,
        ];
    }

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $this->configureFilterFieldAutocompleteSites($filter, 'site', 'MAIL_LOG_ENTITY.LABEL.SITE');
        $this->configureFilterFieldChoice($filter, 'status', $this->getStatusChoices(), 'MAIL_LOG_ENTITY.LABEL.STATUS');
        $this->configureFilterFieldText($filter, 'replyTo', 'MAIL_LOG_ENTITY.LABEL.REPLY_TO');
        $this->configureFilterFieldText($filter, 'recipient', 'MAIL_LOG_ENTITY.LABEL.TO');
        $this->configureFilterFieldText($filter, 'subject', 'MAIL_LOG_ENTITY.LABEL.SUBJECT');
        $this->configureFilterFieldText($filter, 'html', 'MAIL_LOG_ENTITY.LABEL.HTML');
        $this->configureFilterFieldText($filter, 'text', 'MAIL_LOG_ENTITY.LABEL.TEXT');
        $this->configureFilterFieldCreatedAtDateRange($filter);
    }

    protected function configureListFields(ListMapper $list): void
    {
        $this->configureListFieldText(
            $list,
            'messageId',
            'MAIL_LOG_ENTITY.LABEL.ID',
            ['identifier' => true, 'route' => ['name' => 'show']]
        );

        $this->configureListFieldText(
            $list,
            'site_virtual',
            'MAIL_LOG_ENTITY.LABEL.SITE',
            [
                'virtual_field' => true,
                'template'      => 'admin/CRUD/mail-log/list__site.html.twig',
            ]
        );

        $this->configureListFieldEnum($list, 'status', 'MAIL_LOG_ENTITY.LABEL.STATUS');
        $this->configureListFieldText($list, 'sender', 'MAIL_LOG_ENTITY.LABEL.FROM');
        $this->configureListFieldText($list, 'recipient', 'MAIL_LOG_ENTITY.LABEL.TO');
        $this->configureListFieldText($list, 'subject', 'MAIL_LOG_ENTITY.LABEL.SUBJECT');
        $this->configureListFieldCreatedAt($list);
        $this->configureListFieldActions($list, ['show' => []]);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add(
                'site_virtual',
                null,
                [
                    'label'         => 'MAIL_LOG_ENTITY.LABEL.SITE',
                    'virtual_field' => true,
                    'template'      => 'admin/CRUD/mail-log/show__site.html.twig',
                ]
            )
            ->add(
                'status',
                FieldDescriptionInterface::TYPE_ENUM,
                [
                    'label' => 'MAIL_LOG_ENTITY.LABEL.STATUS',
                ]
            )
            ->add('subject', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.SUBJECT'])
            ->add(
                'html',
                null,
                [
                    'label'    => 'MAIL_LOG_ENTITY.LABEL.HTML',
                    'template' => 'admin/CRUD/mail-log/show__html.html.twig',
                ]
            )
            ->add(
                'text',
                null,
                [
                    'label'    => 'MAIL_LOG_ENTITY.LABEL.TEXT',
                    'template' => 'admin/CRUD/mail-log/show__text.html.twig',
                ]
            )
            ->add('sender', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.FROM'])
            ->add('replyTo', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.REPLY_TO'])
            ->add('returnPath', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.RETURN_PATH'])
            ->add('recipient', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.TO'])
            ->add('cc', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.CC'])
            ->add('bcc', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.BCC'])
            ->add('debug', null, ['label' => 'MAIL_LOG_ENTITY.LABEL.DEBUG'])
            ->add('createdAt', 'datetime', ['label' => 'FIELD.CREATED_AT']);
    }
}
