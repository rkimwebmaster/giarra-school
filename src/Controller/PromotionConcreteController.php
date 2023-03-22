<?php

namespace App\Controller;

use App\Entity\PromotionConcrete;
use App\Form\PromotionConcreteType;
use App\Repository\EtudiantAnneeAcademiqueRepository;
use App\Repository\PromotionAbstraiteRepository;
use App\Repository\PromotionConcreteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/promotion/concrete')]
class PromotionConcreteController extends AbstractController
{
    #[Route('/', name: 'app_promotion_concrete_index', methods: ['GET'])]
    public function index(PromotionConcreteRepository $promotionConcreteRepository): Response
    {
        return $this->render('promotion_concrete/index.html.twig', [
            'promotion_concretes' => $promotionConcreteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_promotion_concrete_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PromotionConcreteRepository $promotionConcreteRepository, PromotionAbstraiteRepository $promotionAbstraiteRepository): Response
    {
        $checkPromo=$promotionAbstraiteRepository->findOneBy([]);
        if(!$checkPromo){
            $this->addFlash('danger', 'Aucune promotion générale déjà configuré, contactez l\'admin.');
            return $this->redirectToRoute('app_promotion_abstraite_new', [], Response::HTTP_SEE_OTHER);
        }
        $promotionConcrete = new PromotionConcrete();
        $form = $this->createForm(PromotionConcreteType::class, $promotionConcrete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionConcreteRepository->save($promotionConcrete, true);

            return $this->redirectToRoute('app_promotion_concrete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotion_concrete/new.html.twig', [
            'promotion_concrete' => $promotionConcrete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promotion_concrete_show', methods: ['GET'])]
    public function show(PromotionConcrete $promotionConcrete): Response
    {
        return $this->render('promotion_concrete/show.html.twig', [
            'promotion_concrete' => $promotionConcrete,
        ]);
    }

    
    #[Route('showInscriptions/{id}', name: 'app_promotion_concrete_inscription_show', methods: ['GET'])]
    public function showInscriptions(PromotionConcrete $promotionConcrete): Response
    {
        return $this->render('promotion_concrete/show.html.twig', [
            'promotion_concrete' => $promotionConcrete,
        ]);
    }

    
    #[Route('showReinscriptions/{id}', name: 'app_promotion_reinscription_concrete_show', methods: ['GET'])]
    public function showReinscriptions(PromotionConcrete $promotionConcrete, EtudiantAnneeAcademiqueRepository $etudiantAnneeAcademiqueRepository): Response
    {
        $etudiants=$etudiantAnneeAcademiqueRepository->findBy(['promotionActuelle'=>$promotionConcrete]);
        return $this->render('promotion_concrete/show.html.twig', [
            'promotion_concrete' => $promotionConcrete,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promotion_concrete_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromotionConcrete $promotionConcrete, PromotionConcreteRepository $promotionConcreteRepository): Response
    {
        $form = $this->createForm(PromotionConcreteType::class, $promotionConcrete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionConcreteRepository->save($promotionConcrete, true);

            return $this->redirectToRoute('app_promotion_concrete_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotion_concrete/edit.html.twig', [
            'promotion_concrete' => $promotionConcrete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promotion_concrete_delete', methods: ['POST'])]
    public function delete(Request $request, PromotionConcrete $promotionConcrete, PromotionConcreteRepository $promotionConcreteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotionConcrete->getId(), $request->request->get('_token'))) {
            $promotionConcreteRepository->remove($promotionConcrete, true);
        }

        return $this->redirectToRoute('app_promotion_concrete_index', [], Response::HTTP_SEE_OTHER);
    }
}
