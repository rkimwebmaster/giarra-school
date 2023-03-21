<?php

namespace App\Controller;

use App\Entity\EtudiantAnneeAcademique;
use App\Form\EtudiantAnneeAcademique1Type;
use App\Repository\EtudiantAnneeAcademiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etudiant/annee/academique')]
class EtudiantAnneeAcademiqueController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_annee_academique_index', methods: ['GET'])]
    public function index(EtudiantAnneeAcademiqueRepository $etudiantAnneeAcademiqueRepository): Response
    {
        return $this->render('etudiant_annee_academique/index.html.twig', [
            'etudiant_annee_academiques' => $etudiantAnneeAcademiqueRepository->findAll(),
        ]);
    }

    #[Route('/recherche/etudiant/', name: 'app_recherche_etudiant', methods: ['GET', 'POST'])]
    public function new(Request $request, EtudiantAnneeAcademiqueRepository $etudiantAnneeAcademiqueRepository)
    {
        $keyWord=$request['keyWord']->getData();
       
    }

    #[Route('/{id}', name: 'app_etudiant_annee_academique_show', methods: ['GET'])]
    public function show(EtudiantAnneeAcademique $etudiantAnneeAcademique): Response
    {
        return $this->render('etudiant_annee_academique/show.html.twig', [
            'etudiant_annee_academique' => $etudiantAnneeAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_annee_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtudiantAnneeAcademique $etudiantAnneeAcademique, EtudiantAnneeAcademiqueRepository $etudiantAnneeAcademiqueRepository): Response
    {
        $form = $this->createForm(EtudiantAnneeAcademique1Type::class, $etudiantAnneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etudiantAnneeAcademiqueRepository->save($etudiantAnneeAcademique, true);

            return $this->redirectToRoute('app_etudiant_annee_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etudiant_annee_academique/edit.html.twig', [
            'etudiant_annee_academique' => $etudiantAnneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_annee_academique_delete', methods: ['POST'])]
    public function delete(Request $request, EtudiantAnneeAcademique $etudiantAnneeAcademique, EtudiantAnneeAcademiqueRepository $etudiantAnneeAcademiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiantAnneeAcademique->getId(), $request->request->get('_token'))) {
            $etudiantAnneeAcademiqueRepository->remove($etudiantAnneeAcademique, true);
        }

        return $this->redirectToRoute('app_etudiant_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
