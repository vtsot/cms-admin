<?php

declare(strict_types=1);

namespace App\Contract\CmsEmbed;

use App\Security\User\ApiSiteUser;

interface CmsEmbedInterface
{
    public const CAMPAIGN_PARAM_ID = 'campaign';

    public function getId(): string;

    public function isActive(): bool;

    public function getLabel(): string;

    public function getHelp(): string;

    /**
     * Dialog window parameters.
     *
     * @see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_howtos_dialog_windows.html
     * @see https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dialog_definition.html
     */
    public function getParams(): array;

    public function getPlaceholder(): string;

    public function render(array $params = []): ?string;

    public function getUser(): ?ApiSiteUser;
}
