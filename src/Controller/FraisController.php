<?php

namespace App\Controller;

use App\Entity\Frais;
use App\Form\FraisType;
use App\Repository\AnneeAcademiqueRepository;
use App\Repository\FraisAbstraitRepository;
use App\Repository\FraisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/frais')]
class FraisController extends AbstractController
{
    #[Route('/', name: 'app_frais_index', methods: ['GET'])]
    public function index(FraisRepository $fraisRepository): Response
    {
        return $this->render('frais/index.html.twig', [
            'frais' => $fraisRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_frais_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FraisRepository $fraisRepository, FraisAbstraitRepository $fraisAbstraitRepository, AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        $check=$fraisAbstraitRepository->findOneBy([]);
        if(!$check){
            $this->addFlash('danger','Aucun frais abstrait déjà crée dans le système, contactez l\'admin. ');
            return $this->redirectToRoute('app_frais_abstrait_new', [], Response::HTTP_SEE_OTHER);
        }

        $check2=$anneeAcademiqueRepository->findOneBy([]);
        if(!$check2){
            $this->addFlash('danger','Aucune année academique déjà crée dans le système, contactez l\'admin. ');
            return $this->redirectToRoute('app_annee_academique_new', [], Response::HTTP_SEE_OTHER);
        }
        $frai = new Frais();
        $form = $this->createForm(FraisType::class, $frai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisRepository->save($frai, true);

            return $this->redirectToRoute('app_frais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais/new.html.twig', [
            'frai' => $frai,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_show', methods: ['GET'])]
    public function show(Frais $frai): Response
    {
        return $this->render('frais/show.html.twig', [
            'frai' => $frai,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_frais_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Frais $frai, FraisRepository $fraisRepository): Response
    {
        $form = $this->createForm(FraisType::class, $frai);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisRepository->save($frai, true);

            return $this->redirectToRoute('app_frais_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frais/edit.html.twig', [
            'frai' => $frai,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_frais_delete', methods: ['POST'])]
    public function delete(Request $request, Frais $frai, FraisRepository $fraisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$frai->getId(), $request->request->get('_token'))) {
            $fraisRepository->remove($frai, true);
        }

        return $this->redirectToRoute('app_frais_index', [], Response::HTTP_SEE_OTHER);
    }
}
