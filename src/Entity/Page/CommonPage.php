<?php

declare(strict_types=1);

namespace App\Entity\Page;

use App\Repository\Page\CommonPageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommonPageRepository::class)]
class CommonPage extends AbstractPage
{
}
