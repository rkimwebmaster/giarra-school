<?php

namespace App\Controller;

use App\Entity\FaculteSection;
use App\Form\FaculteSectionType;
use App\Repository\DepartementRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FaculteSectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/faculte/section')]
class FaculteSectionController extends AbstractController
{
    #[Route('/', name: 'app_faculte_section_index', methods: ['GET'])]
    public function index(FaculteSectionRepository $faculteSectionRepository): Response
    {
        return $this->render('faculte_section/index.html.twig', [
            'faculte_sections' => $faculteSectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_faculte_section_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DepartementRepository $departementRepository, FaculteSectionRepository $faculteSectionRepository, EntrepriseRepository $entrepriseRepository): Response
    {

        
        $check=$entrepriseRepository->findOneBy([]);
        if(!$check){
            $this->addFlash('danger', 'Aucune infos de votre université configuré, contactez l\'admin.');
            return $this->redirectToRoute('app_entreprise_new', [], Response::HTTP_SEE_OTHER);
        }
        $faculteSection = new FaculteSection();
        $form = $this->createForm(FaculteSectionType::class, $faculteSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faculteSectionRepository->save($faculteSection, true);

            $checkDpt=$departementRepository->findOneBy([]);
            if(!$checkDpt){
                $this->addFlash('danger', 'Merci de configurer les options ci-dessous');
                return $this->redirectToRoute('app_promotion_concrete_new', [], Response::HTTP_SEE_OTHER);
            }

            return $this->redirectToRoute('app_faculte_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faculte_section/new.html.twig', [
            'faculte_section' => $faculteSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_faculte_section_show', methods: ['GET'])]
    public function show(FaculteSection $faculteSection): Response
    {
        return $this->render('faculte_section/show.html.twig', [
            'faculte_section' => $faculteSection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_faculte_section_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FaculteSection $faculteSection, FaculteSectionRepository $faculteSectionRepository): Response
    {
        $form = $this->createForm(FaculteSectionType::class, $faculteSection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $faculteSectionRepository->save($faculteSection, true);

            return $this->redirectToRoute('app_faculte_section_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faculte_section/edit.html.twig', [
            'faculte_section' => $faculteSection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_faculte_section_delete', methods: ['POST'])]
    public function delete(Request $request, FaculteSection $faculteSection, FaculteSectionRepository $faculteSectionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faculteSection->getId(), $request->request->get('_token'))) {
            $faculteSectionRepository->remove($faculteSection, true);
        }

        return $this->redirectToRoute('app_faculte_section_index', [], Response::HTTP_SEE_OTHER);
    }
}
