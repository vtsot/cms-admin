<?php

declare(strict_types=1);

namespace App\Controller;

use Carbon\Carbon;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseAbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractController extends BaseAbstractController
{
    protected function handleFileResponse(
        Request $request,
        ?SplFileInfo $file,
        int $status = Response::HTTP_OK,
        array $headers = [],
    ): Response {
        if ($file === null) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $lastModifiedDate = Carbon::createFromTimestamp($file->getMTime());

        if ($request->headers->has('If-Modified-Since')
            && new Carbon($request->headers->get('If-Modified-Since')) >= $lastModifiedDate
        ) {
            return new Response(null, Response::HTTP_NOT_MODIFIED);
        }

        return new BinaryFileResponse($file, $status, $headers)->setLastModified($lastModifiedDate)->setAutoEtag();
    }
}
