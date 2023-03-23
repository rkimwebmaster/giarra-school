<?php

namespace App\Controller;

use App\Entity\PromotionAbstraite;
use App\Form\PromotionAbstraiteType;
use App\Repository\DepartementRepository;
use App\Repository\PromotionAbstraiteRepository;
use App\Repository\PromotionConcreteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/promotion/abstraite')]
class PromotionAbstraiteController extends AbstractController
{
    #[Route('/', name: 'app_promotion_abstraite_index', methods: ['GET'])]
    public function index(PromotionAbstraiteRepository $promotionAbstraiteRepository): Response
    {
        return $this->render('promotion_abstraite/index.html.twig', [
            'promotion_abstraites' => $promotionAbstraiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_promotion_abstraite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PromotionConcreteRepository $promotionConcreteRepository, PromotionAbstraiteRepository $promotionAbstraiteRepository, DepartementRepository $departementRepository): Response
    {

        $checkPromo=$departementRepository->findOneBy([]);
        if(!$checkPromo){
            $this->addFlash('danger', 'Aucun département générale déjà configuré, contactez l\'admin.');
            return $this->redirectToRoute('app_departement_new', [], Response::HTTP_SEE_OTHER);
        }
        $promotionAbstraite = new PromotionAbstraite();
        $form = $this->createForm(PromotionAbstraiteType::class, $promotionAbstraite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionAbstraiteRepository->save($promotionAbstraite, true);

            $checkPromo=$promotionConcreteRepository->findOneBy([]);
            if(!$checkPromo){
                $this->addFlash('danger', 'Mecri de configurer les promotions annuelles ci-dessous');
                return $this->redirectToRoute('app_promotion_concrete_new', [], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_promotion_abstraite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotion_abstraite/new.html.twig', [
            'promotion_abstraite' => $promotionAbstraite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promotion_abstraite_show', methods: ['GET'])]
    public function show(PromotionAbstraite $promotionAbstraite): Response
    {
        return $this->render('promotion_abstraite/show.html.twig', [
            'promotion_abstraite' => $promotionAbstraite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promotion_abstraite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromotionAbstraite $promotionAbstraite, PromotionAbstraiteRepository $promotionAbstraiteRepository): Response
    {
        $form = $this->createForm(PromotionAbstraiteType::class, $promotionAbstraite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promotionAbstraiteRepository->save($promotionAbstraite, true);

            return $this->redirectToRoute('app_promotion_abstraite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotion_abstraite/edit.html.twig', [
            'promotion_abstraite' => $promotionAbstraite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promotion_abstraite_delete', methods: ['POST'])]
    public function delete(Request $request, PromotionAbstraite $promotionAbstraite, PromotionAbstraiteRepository $promotionAbstraiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotionAbstraite->getId(), $request->request->get('_token'))) {
            $promotionAbstraiteRepository->remove($promotionAbstraite, true);
        }

        return $this->redirectToRoute('app_promotion_abstraite_index', [], Response::HTTP_SEE_OTHER);
    }
}
