<?php

declare(strict_types=1);

namespace App\ArgumentResolver;

use App\Contract\ControllerRequest\ControllerRequestInterface;
use App\DTOFactory\ControllerRequest\ControllerRequestFactory;
use App\Service\Util;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

use function array_merge;
use function class_exists;
use function filter_var;
use function is_subclass_of;
use function str_starts_with;
use function strlen;

use const FILTER_NULL_ON_FAILURE;
use const FILTER_VALIDATE_FLOAT;
use const FILTER_VALIDATE_INT;

class ApiRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ControllerRequestFactory $apiRequestFactory,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        $argumentType = $argument->getType();

        if (
            !$argumentType
            || !class_exists($argumentType)
            || !is_subclass_of($argumentType, ControllerRequestInterface::class, true)
        ) {
            return [];
        }

        $data = array_merge($this->getRequestParams($request), $this->getRouteParams($request));

        $object = $this->apiRequestFactory->fromArray($data, $argumentType);

        return [$object];
    }

    private function getRequestParams(Request $request): array
    {
        return Util::arrayKeysToSnake($request->query->all())
            + Util::arrayKeysToSnake($request->request->all());
    }

    private function getRouteParams(Request $request): array
    {
        $params = $request->attributes->get('_route_params', []);

        foreach ($params as $key => $param) {
            // skip value convert when it starts from "0" and consists of more than "1" symbols
            if (strlen((string) $param) > 1 && str_starts_with($param[0], '0')) {
                continue;
            }

            $value = filter_var($param, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

            if ($value === null) {
                $value = filter_var($param, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
            }
            $params[$key] = $value ?? $param;
        }

        return Util::arrayKeysToSnake($params);
    }
}
