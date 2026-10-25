<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261022154456 extends AbstractMigration
{
    private const SUPER_ADMIN = 'super-admin@example.com';

    public function up(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        INSERT INTO `users`
        SET
            `id`         = :id,
            `active`     = :active,
            `email`      = :email,
            `password`   = :password,
            `roles`      = :roles,
            `created_at` = NOW(),
            `updated_at` = NOW()
        ',
        [
            'id'       => new \Symfony\Component\Uid\UuidV7()->toBinary(),
            'active'   => 1,
            'email'    => self::SUPER_ADMIN,
            'password' => '$2y$13$UbJK5a4z6hPBNO3PP4TFQ.aXBGMC1wn5r5f9GFKFbWBAMloPWyl4C',
            'roles'    => '["ROLE_SUPERVISOR"]',
        ]
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
        /** @lang MySQL */ '
        DELETE FROM `users` WHERE `email` = :email
        ',
        ['email' => self::SUPER_ADMIN]
        );
    }
}
