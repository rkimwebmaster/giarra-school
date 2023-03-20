<?php

namespace App\Controller;

use App\Entity\FraisAbstrait;
use App\Form\FraisAbstraitType;
use App\Repository\FraisAbstraitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frais/abstrait')]
class FraisAbstraitController extends AbstractController
{
    #[Route('/', name: 'app_frais_abstrait_index', methods: ['GET'])]
    public function index(FraisAbstraitRepository $fraisAbstraitRepository): Response
    {
        return $this->render('frais_abstrait/index.html.twig', [
            'frais_abstraits' => $fraisAbstraitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frais_abstrait_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FraisAbstraitRepository $fraisAbstraitRepository): Response
    {
        $fraisAbstrait = new FraisAbstrait();
        $form = $this->createForm(FraisAbstraitType::class, $fraisAbstrait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisAbstraitRepository->save($fraisAbstrait, true);

            return $this->redirectToRoute('app_frais_abstrait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_abstrait/new.html.twig', [
            'frais_abstrait' => $fraisAbstrait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_abstrait_show', methods: ['GET'])]
    public function show(FraisAbstrait $fraisAbstrait): Response
    {
        return $this->render('frais_abstrait/show.html.twig', [
            'frais_abstrait' => $fraisAbstrait,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frais_abstrait_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FraisAbstrait $fraisAbstrait, FraisAbstraitRepository $fraisAbstraitRepository): Response
    {
        $form = $this->createForm(FraisAbstraitType::class, $fraisAbstrait);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisAbstraitRepository->save($fraisAbstrait, true);

            return $this->redirectToRoute('app_frais_abstrait_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais_abstrait/edit.html.twig', [
            'frais_abstrait' => $fraisAbstrait,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_abstrait_delete', methods: ['POST'])]
    public function delete(Request $request, FraisAbstrait $fraisAbstrait, FraisAbstraitRepository $fraisAbstraitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fraisAbstrait->getId(), $request->request->get('_token'))) {
            $fraisAbstraitRepository->remove($fraisAbstrait, true);
        }

        return $this->redirectToRoute('app_frais_abstrait_index', [], Response::HTTP_SEE_OTHER);
    }
}
