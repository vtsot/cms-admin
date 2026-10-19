<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use App\Entity\Cms\CourseFilterPreset\CmsCourseFilterPreset as CourseFilter;
use App\Entity\Page\AbstractPage;

interface LinkSecondEntityInterface extends LinkEntityInterface
{
    public function getLinkSecondType(): ?string;

    public function getLinkSecondPage(): ?AbstractPage;

    public function getLinkSecondUrl(): ?string;

    public function getLinkSecondCourseFilter(): ?CourseFilter;
}
