<?php

declare(strict_types=1);

namespace App\Entity\Navigation;

use App\Contract\Dictionary\NavigationType;
use App\Repository\Navigation\TopNavigationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopNavigationRepository::class)]
class TopNavigation extends AbstractNavigation
{
    public function __construct()
    {
        parent::__construct();

        $this->setType(NavigationType::Top);
    }
}
