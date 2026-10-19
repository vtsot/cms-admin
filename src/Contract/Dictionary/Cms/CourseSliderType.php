<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\Cms;

enum CourseSliderType: string
{
    case MyCourses    = 'my';
    case RecentViewed = 'recent-viewed';
    case Manual       = 'manual';
    case Bookmarks    = 'course-bookmarks';
    case All          = 'all';
}
