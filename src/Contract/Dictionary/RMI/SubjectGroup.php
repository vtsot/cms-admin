<?php

declare(strict_types=1);

namespace App\Contract\Dictionary\RMI;

enum SubjectGroup: string
{
    case Engine       = 'engine';
    case Transmission = 'transmission';
    case Steering     = 'steering';
    case Brakes       = 'brakes';
    case Exterior     = 'exterior';
    case Electronics  = 'electronics';
    case All          = 'all';

    public static function fromHP(string $subjectGroup): self
    {
        return match ($subjectGroup) {
            'ENGINE'       => self::Engine,
            'TRANSMISSION' => self::Transmission,
            'STEERING'     => self::Steering,
            'BRAKES'       => self::Brakes,
            'EXTERIOR'     => self::Exterior,
            'ELECTRONICS'  => self::Electronics,
            'QUICKGUIDES'  => self::All,
        };
    }

    public function toHP(): string
    {
        return match ($this) {
            self::Engine       => 'ENGINE',
            self::Transmission => 'TRANSMISSION',
            self::Steering     => 'STEERING',
            self::Brakes       => 'BRAKES',
            self::Exterior     => 'EXTERIOR',
            self::Electronics  => 'ELECTRONICS',
            self::All          => 'QUICKGUIDES',
        };
    }
}
