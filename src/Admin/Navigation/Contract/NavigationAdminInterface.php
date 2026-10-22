<?php

declare(strict_types=1);

namespace App\Admin\Navigation\Contract;

use Sonata\AdminBundle\Admin\AdminInterface;

interface NavigationAdminInterface extends AdminInterface
{
    public function getChildListRoute(): ?string;

    public function addChildNavigation(AdminInterface $admin, ?string $field = null, ?string $route = null): void;
}
