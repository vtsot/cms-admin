<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

abstract class ApiDocTag
{
    public const AUTH                          = '01 Auth';
    public const REGISTER                      = '02 Register';
    public const USERS                         = '03 Users';
    public const USERS_ME_PROFILE              = '04 My Profile';
    public const USERS_ME_IMAGE                = '05 My Profile Images';
    public const USERS_ME_DISCOUNT             = '06 My Profile Discounts';
    public const USERS_ME_NOTIFICATION_CONFIGS = '07 My Profile Notification Configs';
    public const VIDEOS                        = '08 Videos';
    public const WORKSHOPS                     = '09 Workshops';
    public const WORKSHOP_USERS                = '10 Workshop users';
    public const WORKSHOP_PROFILE_IMAGES       = '11 Workshop Profile Images';
    public const WORKSHOP_ADDRESSES            = '12 Workshop Addresses';
    public const WORKSHOP_MAKES                = '13 Workshop Makes';
    public const WORKSHOP_SKILLS               = '14 Workshop Skills';
    public const CATEGORIES                    = '15 Categories';
    public const VEHICLES                      = '16 Vehicles';
    public const COURSES                       = '17 Courses';
    public const COURSE_COMMENTS               = '18 Course Comments';
    public const TAGS                          = '19 Tags';
    public const SUPPORT_REQUEST               = '20 Support Request';
    public const SUPPORT_CREDIT_PACKAGES       = '21 Support Credit Package';
    public const ADMIN                         = '22 Admin';
    public const SUBSCRIPTION_PLANS            = '23 Subscription Plan';
    public const CERTIFICATIONS                = '24 Certifications';
    public const STATISTIC                     = '25 Statistic';
    public const DYNAMIC_LINKS                 = '26 Dynamic Links';
    public const REPAIR_GUIDES                 = '27 Repair Guides';
    public const SIGNATURES                    = '28 Signatures';
    public const ORDERS                        = '29 Orders';

    public const MAIL    = '98 Mail';
    public const GENERAL = '99 General';
}
