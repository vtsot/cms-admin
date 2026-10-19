<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Repository\Page\SystemPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SystemPageRepository::class)]
class SystemPage extends AbstractPage
{
}
