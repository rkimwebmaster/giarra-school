<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\PromotionConcrete;
use App\Form\InscriptionType;
use App\Repository\FraisRepository;
use App\Repository\InscriptionRepository;
use App\Repository\PaiementRepository;
use App\Repository\PromotionConcreteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/', name: 'app_inscription_index', methods: ['GET'])]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_inscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request,PromotionConcrete $promotionConcrete, PaiementRepository $paiementRepository, InscriptionRepository $inscriptionRepository,FraisRepository $fraisRepository, PromotionConcreteRepository $promotionConcreteRepository): Response
    {
        $checkPromotions=$promotionConcreteRepository->findOneBy([]);
        if(!$checkPromotions){
            $this->addFlash('danger', 'Aucune promotion déjà configuré, contactez l\'admin.');
            return $this->redirectToRoute('app_promotion_concrete_new', [], Response::HTTP_SEE_OTHER);
        }

        $checkFrais=$fraisRepository->findOneBy([]);
        if(!$checkFrais){
            $this->addFlash('danger', 'Aucun frais annuel déjà configuré, rassurez-vous que les frais INSCRPTION soit configuré. Contactez l\'admin.');
            return $this->redirectToRoute('app_frais_new', [], Response::HTTP_SEE_OTHER);
        }

        $inscription = new Inscription($promotionConcrete);
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription->setUtilisateur($this->getUser());

            $etudiantPremier=$form['premierEtudiantAnneeAcademique']->getData();
            $etudiantPremier->setPromotionActuelle($inscription->getPromotionConcrete());
            $inscription->addEtudiantAnneeAcademique($etudiantPremier);
            
            $inscription->getPaiement()->setUtilisateur($this->getUser());
            $inscription->getPaiement()->setEtudiantAnneeAcademique($etudiantPremier);
            
            // dd();
            $paiementRepository->save($inscription->getPaiement(), true);
            $inscriptionRepository->save($inscription, true);
            // dd($inscription->getEtudiantAnneeAcademique());
            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscription_show', methods: ['GET'])]
    public function show(Inscription $inscription): Response
    {
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inscriptionRepository->save($inscription, true);

            return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscription_delete', methods: ['POST'])]
    public function delete(Request $request, Inscription $inscription, InscriptionRepository $inscriptionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            $inscriptionRepository->remove($inscription, true);
        }

        return $this->redirectToRoute('app_inscription_index', [], Response::HTTP_SEE_OTHER);
    }
}
