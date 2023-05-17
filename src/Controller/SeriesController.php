<?php

namespace App\Controller;

use App\Entity\Series;
use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeriesController extends AbstractController
{

    public function __construct(private readonly SeriesRepository $seriesRepository)
    {
    }

    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function index(): Response
    {
        $series = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/series/create', name: 'app_series_form_create', methods: ['GET'])]
    public function formCreate(): Response
    {
        return $this->render('series/form/create.html.twig');
    }

    #[Route('/series', name: 'app_series_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $inputSeriesName = $request->request->get('name');
        $series = new Series($inputSeriesName);

        $this->seriesRepository->save(entity: $series, flush: true);

        return new RedirectResponse('/series');
    }
}
