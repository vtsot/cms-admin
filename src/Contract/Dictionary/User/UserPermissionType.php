<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\User;

use App\Contract\Dictionary\Traits\EnumValuesTrait;

enum UserPermissionType: string
{
    use EnumValuesTrait;

    case StartTrial                   = 'subscription:start-trial';
    case CreateWorkshop               = 'workshop:create';
    case CreateWorkshopUser           = 'workshop-user:create';
    case StandardSupportRequestCreate = 'support-request:create-standard';

    case PremiumSupportRequestCreate = 'support-request:create-premium';
    case SearchVehicleByVin          = 'vehicle:search-by-vin';
    case SearchVehicleByKba          = 'vehicle:search-by-kba';
    case ViewRmiMaintenanceData      = 'rmi:view-maintenance-data';
    case ViewRmiManuals              = 'rmi:view-manuals';
    case ViewRmiDrawings             = 'rmi:view-drawings';
    case ViewRmiSmartRepair          = 'rmi:view-smart-repair';
}
