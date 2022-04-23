<?php

declare(strict_types=1);

namespace App\Controller;

use App\MyTaggedServices\ChainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnyController extends AbstractController
{
    public function __construct(private ChainService $chainService)
    {
    }

    #[Route(path: '/', name: 'home')]
    public function index(): Response
    {
        $this->chainService->doStuff();

        return new Response('ok');
    }
}