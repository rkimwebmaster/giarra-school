<?php

namespace App\Controller;

use App\Entity\AnneeAcademique;
use App\Form\AnneeAcademiqueType;
use App\Repository\AnneeAcademiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annee/academique')]
class AnneeAcademiqueController extends AbstractController
{
    #[Route('/', name: 'app_annee_academique_index', methods: ['GET'])]
    public function index(AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        return $this->render('annee_academique/index.html.twig', [
            'annee_academiques' => $anneeAcademiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annee_academique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        $anneeAcademique = new AnneeAcademique();
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $check=$anneeAcademiqueRepository->findOneBy(['isEnCours'=>true]);
            if(!$check){
                $anneeAcademique->setIsEnCours(true);
            }
            if($anneeAcademique->isIsEnCours()){
                $check=$anneeAcademiqueRepository->findOneBy(['isEnCours'=>true]);
                if($check){
                    $check->setIsEnCours(false);
                    $anneeAcademiqueRepository->save($check, true);
                }
            }
            $anneeAcademiqueRepository->save($anneeAcademique, true);

            return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annee_academique/new.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_show', methods: ['GET'])]
    public function show(AnneeAcademique $anneeAcademique): Response
    {
        return $this->render('annee_academique/show.html.twig', [
            'annee_academique' => $anneeAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeAcademique $anneeAcademique, AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anneeAcademiqueRepository->save($anneeAcademique, true);

            return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annee_academique/edit.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeAcademique $anneeAcademique, AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeAcademique->getId(), $request->request->get('_token'))) {
            $anneeAcademiqueRepository->remove($anneeAcademique, true);
        }

        return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
