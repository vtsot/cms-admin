<?php

declare(strict_types=1);

namespace App\Contract\Entity;

use App\Entity\Cms\CourseFilterPreset\CmsCourseFilterPreset as CourseFilter;
use App\Entity\Page\AbstractPage;

interface LinkEntityInterface
{
    public const TARGET_TOP   = '_top';
    public const TARGET_BLANK = '_blank';

    public const LINK_TYPE_PAGE          = 'page';
    public const LINK_TYPE_EXTERNAL_LINK = 'link';
    public const LINK_TYPE_COURSE_FILTER = 'course_filter';

    public function getLinkType(): ?string;

    public function getLinkPage(): ?AbstractPage;

    public function getLinkUrl(): ?string;

    public function getLinkCourseFilter(): ?CourseFilter;
}
