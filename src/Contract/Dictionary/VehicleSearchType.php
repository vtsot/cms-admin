<?php

declare(strict_types=1);

namespace App\Contract\Dictionary;

use App\Contract\Dictionary\RMI\CategoryType as RmiCategoryType;
use InvalidArgumentException;

use function sprintf;

enum VehicleSearchType: string
{
    case Vin                = 'vin';
    case Kba                = 'kba';
    case RmiMaintenanceData = 'rmi-maintenance-data';
    case RmiManuals         = 'rmi-manuals';
    case RmiSmartRepair     = 'rmi-smart-repair';
    case RmiDrawings        = 'rmi-drawings';

    public static function fromRMICategory(string $value): self
    {
        $vehicleSearchType = match ($value) {
            // RmiMaintenanceData
            RmiCategoryType::BatteryManagement->value,
            RmiCategoryType::CabinAirFilters->value,
            RmiCategoryType::InspectionData->value,
            RmiCategoryType::TechnicalData->value,
            RmiCategoryType::Lubricants->value,
            RmiCategoryType::TimingBeltData->value,
            RmiCategoryType::WorkingValues->value,
            RmiCategoryType::ManufacturerPromotions->value,
            RmiCategoryType::RecallCampaigns->value => self::RmiMaintenanceData,

            // RmiManuals, RmiSmartRepair
            RmiCategoryType::ComponentsLocations->value,
            RmiCategoryType::RepairInstructions->value,
            RmiCategoryType::WarningLights->value,
            RmiCategoryType::ServiceResets->value,
            RmiCategoryType::DiagnosticDatabase->value,
            RmiCategoryType::DieselSystems->value => self::RmiSmartRepair,

            // RmiDrawings
            RmiCategoryType::FusesRelays->value,
            RmiCategoryType::ComponentTestValues->value,
            RmiCategoryType::TechnicalDrawings->value,
            RmiCategoryType::WiringDiagrams->value => self::RmiDrawings,

            default => null,
        };

        if ($vehicleSearchType === null) {
            throw new InvalidArgumentException(
                sprintf('The VehicleSearch was not determined for the RMI Category value "%s".', $value)
            );
        }

        return $vehicleSearchType;
    }

    public static function tryFromRMICategory(string $value): ?self
    {
        try {
            return self::fromRMICategory($value);
        } catch (InvalidArgumentException) {
        }

        return null;
    }
}
