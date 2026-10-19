<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum CategoryType: string
{
    case BatteryManagement      = 'battery-management';
    case CabinAirFilters        = 'cabin-air-filters';
    case ComponentsLocations    = 'components-locations';
    case ComponentTestValues    = 'component-test-values';
    case DiagnosticDatabase     = 'diagnostic-database';
    case DieselSystems          = 'diesel-systems';
    case FusesRelays            = 'fuses-relays';
    case InspectionData         = 'inspection-data';
    case ManufacturerPromotions = 'manufacturer-promotions';
    case RecallCampaigns        = 'recall-campaigns';
    case RepairInstructions     = 'repair-instructions';
    case ServiceResets          = 'service-resets';
    case TechnicalData          = 'technical-data';
    case TimingBeltData         = 'timing-belt-data';
    case WarningLights          = 'warning-lights';
    case WiringDiagrams         = 'wiring-diagrams';
    case WorkingValues          = 'working-values';
    case TechnicalDrawings      = 'technical-drawings';
    case Lubricants             = 'lubricants';
}
