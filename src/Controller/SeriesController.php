<?php

namespace App\Controller;

use App\Dto\SeriesUpdateDto;
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

    #[Route(path: '/series', name: 'app_series', methods: ['GET'])]
    public function index(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route(path: '/series/create', name: 'app_series_form_create', methods: ['GET'])]
    public function formCreate(): Response
    {
        return $this->render('series/form/create.html.twig');
    }

    #[Route(path: '/series', name: 'app_series_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $inputName = $request->request->get('name');
        $series = new Series($inputName);

        $this->seriesRepository->save(entity: $series, flush: true);

        return new RedirectResponse('/series');
    }

    #[Route(
        path: '/series/update/{id}',
        name: 'app_series_form_update',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function formUpdate(int $id): Response
    {
        $series = $this->seriesRepository->find($id);

        return $this->render('series/form/update.html.twig', [
            'series' => $series
        ]);
    }

    #[Route(
        path: '/series/{id}',
        name: 'app_series_update',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function update(int $id, Request $request): Response
    {
        $seriesForm = new SeriesUpdateDto($request->request);
        $series = $this->seriesRepository->find($id);

        $series->setName($seriesForm->name);
        $this->seriesRepository->save(entity: $series, flush: true);

        return new RedirectResponse('/series');
    }

    #[Route(
        path: '/series/{id}',
        name: 'app_series_delete',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]
    public function delete(int $id): Response
    {
        $series = $this->seriesRepository->find($id);

        $this->seriesRepository->remove(entity: $series, flush: true);

        return new RedirectResponse('/series');
    }
}
