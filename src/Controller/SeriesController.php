<?php

namespace App\Controller;

use App\Entity\Series;
use App\Form\SeriesType;
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
            'seriesList' => $seriesList
        ]);
    }

    #[Route(path: '/series/create', name: 'app_series_form_create', methods: ['GET'])]
    public function formCreate(): Response
    {
        $seriesForm = $this->createForm(SeriesType::class, new Series(''));
        return $this->render(
            view: 'series/form/create.html.twig',
            parameters: compact('seriesForm')
        );
    }

    #[Route(path: '/series', name: 'app_series_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $series = new Series('');
        $seriesForm = $this->createForm(SeriesType::class, $series)
            ->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->render(
                view: 'series/form/create.html.twig',
                parameters: compact('seriesForm')
            );
        }

        $this->seriesRepository->save(entity: $series, flush: true);

        $this->addFlash("success", "Série {$series->getName()} adicionada com sucesso!");

        return new RedirectResponse('/series');
    }

    #[Route(
        path: '/series/update/{id}',
        name: 'app_series_form_update',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function formUpdate(Series $series): Response
    {
        $seriesForm = $this->createForm(
            SeriesType::class,
            $series,
            [
                'is_create' => false,
                'id' => $series->getId()
            ]
        );

        return $this->render(
            view: 'series/form/update.html.twig',
            parameters: compact('seriesForm')
        );
    }

    #[Route(
        path: '/series/{id}',
        name: 'app_series_update',
        requirements: ['id' => '\d+'],
        methods: ['PATCH']
    )]
    public function update(Series $series, Request $request): Response
    {
        $seriesForm = $this->createForm(
            SeriesType::class,
            $series,
            [
                'is_create' => false,
                'id' => $series->getId()
            ]
        );
        $seriesForm->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->render(
                view: 'series/form/update.html.twig',
                parameters: compact('seriesForm')
            );
        }

        $this->seriesRepository->save(entity: $series, flush: true);

        $this->addFlash("success", "Série {$series->getName()} atualizada com sucesso!");

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

        $this->addFlash("success", "Série {$series->getName()} removida com sucesso!");

        return new RedirectResponse('/series');
    }
}
