<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum Subject: string
{
    case GeneralInfo         = 'general_info';
    case Maintenance         = 'maintenance';
    case Lubricants          = 'lubricants';
    case Drawings            = 'drawings';
    case EobdLocations       = 'eobd_locations';
    case FuseLocations       = 'fuse_locations';
    case EngineLocations     = 'engine_locations';
    case Stories             = 'stories';
    case WarningLights       = 'warning_lights';
    case WiringDiagrams      = 'wiring_diagrams';
    case RepairTimes         = 'repair_times';
    case TimingRepairManuals = 'timing_repair_manuals';
    case Tsb                 = 'tsb';
    case Cases               = 'cases';

    public static function fromHP(string $subject): ?Subject
    {
        return match ($subject) {
            'ADJUSTMENTS'           => self::GeneralInfo,
            'MAINTENANCE'           => self::Maintenance,
            'LUBRICANTS'            => self::Lubricants,
            'DRAWINGS'              => self::Drawings,
            'EOBD_LOCATIONS'        => self::EobdLocations,
            'FUSE_LOCATIONS'        => self::FuseLocations,
            'ENGINE_LOCATIONS'      => self::EngineLocations,
            'STORIES'               => self::Stories,
            'WARNING_LIGHTS'        => self::WarningLights,
            'WIRING_DIAGRAMS'       => self::WiringDiagrams,
            'REPAIR_TIMES'          => self::RepairTimes,
            'TIMING_REPAIR_MANUALS' => self::TimingRepairManuals,
            'TSB'                   => self::Tsb,
            'Cases'                 => self::Cases,
            default                 => null,
        };
    }

    public function toHP(): string
    {
        return match ($this) {
            self::GeneralInfo         => 'ADJUSTMENTS',
            self::Maintenance         => 'MAINTENANCE',
            self::Lubricants          => 'LUBRICANTS',
            self::Drawings            => 'DRAWINGS',
            self::EobdLocations       => 'EOBD_LOCATIONS',
            self::FuseLocations       => 'FUSE_LOCATIONS',
            self::EngineLocations     => 'ENGINE_LOCATIONS',
            self::Stories             => 'STORIES',
            self::WarningLights       => 'WARNING_LIGHTS',
            self::WiringDiagrams      => 'WIRING_DIAGRAMS',
            self::RepairTimes         => 'REPAIR_TIMES',
            self::TimingRepairManuals => 'TIMING_REPAIR_MANUALS',
            self::Tsb                 => 'TSB',
            self::Cases               => 'Cases',
        };
    }
}
