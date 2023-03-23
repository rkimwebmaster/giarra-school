<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use App\Repository\FaculteSectionRepository;
use App\Repository\PromotionAbstraiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/departement')]
class DepartementController extends AbstractController
{
    #[Route('/', name: 'app_departement_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository): Response
    {
        return $this->render('departement/index.html.twig', [
            'departements' => $departementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PromotionAbstraiteRepository $promotionAbstraiteRepository, DepartementRepository $departementRepository, FaculteSectionRepository $faculteSectionRepository): Response
    {
        
        $check=$faculteSectionRepository->findOneBy([]);
        if(!$check){
            $this->addFlash('danger', 'Aucune section configurée, contactez l\'admin.');
            return $this->redirectToRoute('app_faculte_section_new', [], Response::HTTP_SEE_OTHER);
        }
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departementRepository->save($departement, true);
            // dd("je suis");

            // $checkPmA=$promotionAbstraiteRepository->findOneBy(['danger', 'Merci de configurer les promotions générales ci-dessous']);
            // dd("je suis");

            // if(!$checkPmA){
            //     $this->addFlash('danger', 'configurer les classes Générales ');
            //     return $this->redirectToRoute('app_promotion_promotion_abstraite_new', [], Response::HTTP_SEE_OTHER);
            // }

            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departement_show', methods: ['GET'])]
    public function show(Departement $departement): Response
    {
        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departement $departement, DepartementRepository $departementRepository): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $departementRepository->save($departement, true);

            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departement_delete', methods: ['POST'])]
    public function delete(Request $request, Departement $departement, DepartementRepository $departementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $departementRepository->remove($departement, true);
        }

        return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
