<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{
    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function index(): Response
    {
        $series = ['A', 'B'];

        return $this->render('series/index.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/series/create', name: 'app_series_form_create', methods: ['GET'])]
    public function formCreate(): Response
    {
        return $this->render('series/form/create.html.twig');
    }
}
