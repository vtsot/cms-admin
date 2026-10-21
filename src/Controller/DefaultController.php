<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route(
        path: '',
        name: 'web.homepage',
        options: ['expose' => true],
        methods: ['GET'],
    )]
    public function index(): Response
    {
        return $this->redirectToRoute('sonata_admin_redirect');
    }
}
