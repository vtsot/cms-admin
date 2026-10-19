<?php

declare(strict_types=1);

namespace App\Admin\Page;

use App\Entity\Page\SystemPage;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

/**
 * @method SystemPage|null getSubject()
 */
class SystemPageAdmin extends AbstractPageAdmin
{
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);

        $collection->remove('delete');
        $collection->remove('create');
    }
}
