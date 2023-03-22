<?php

namespace App\Controller;

use App\Entity\EtudiantAnneeAcademique;
use App\Entity\Inscription;
use App\Entity\Reinscription;
use App\Form\ReinscriptionType;
use App\Repository\InscriptionRepository;
use App\Repository\ReinscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reinscription')]
class ReinscriptionController extends AbstractController
{
    #[Route('/', name: 'app_reinscription_index', methods: ['GET'])]
    public function index(ReinscriptionRepository $reinscriptionRepository): Response
    {
        return $this->render('reinscription/index.html.twig', [
            'reinscriptions' => $reinscriptionRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_reinscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtudiantAnneeAcademique $etudiantAnneeAcademique, ReinscriptionRepository $reinscriptionRepository, InscriptionRepository $inscriptionRepository): Response
    {
        $checkPromotions=$inscriptionRepository->findOneBy([]);
        if(!$checkPromotions){
            $this->addFlash('danger', 'Aucune inscription dans le système, contactez l\'admin.');
            return $this->redirectToRoute('app_inscription_new', [], Response::HTTP_SEE_OTHER);

        }
        
        $reinscription = new Reinscription($etudiantAnneeAcademique);
        $reinscription->setUtilisateur($this->getUser());
        $form = $this->createForm(ReinscriptionType::class, $reinscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reinscriptionRepository->save($reinscription, true);

            return $this->redirectToRoute('app_reinscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reinscription/new.html.twig', [
            'reinscription' => $reinscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reinscription_show', methods: ['GET'])]
    public function show(Reinscription $reinscription): Response
    {
        return $this->render('reinscription/show.html.twig', [
            'reinscription' => $reinscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reinscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reinscription $reinscription, ReinscriptionRepository $reinscriptionRepository): Response
    {
        $form = $this->createForm(ReinscriptionType::class, $reinscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reinscriptionRepository->save($reinscription, true);

            return $this->redirectToRoute('app_reinscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reinscription/edit.html.twig', [
            'reinscription' => $reinscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reinscription_delete', methods: ['POST'])]
    public function delete(Request $request, Reinscription $reinscription, ReinscriptionRepository $reinscriptionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reinscription->getId(), $request->request->get('_token'))) {
            $reinscriptionRepository->remove($reinscription, true);
        }

        return $this->redirectToRoute('app_reinscription_index', [], Response::HTTP_SEE_OTHER);
    }
}
