<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\AnneeAcademiqueRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\PromotionConcreteRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Security $security, Session $session, UserPasswordHasherInterface $hasher, EntrepriseRepository $entrepriseRepository, UserRepository $userRepository, AnneeAcademiqueRepository $anneeAcademiqueRepository, PromotionConcreteRepository $promotionConcreteRepository): Response
    {

        //tentative de creation de l'admin
        $checkUser = $userRepository->findOneBy([]);
        if (!$checkUser) {
            $user = new User();
            $plaintextPassword = "admin";
            // $hasher->hash
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $hasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setEmail('admin@ice.cd');

            $userRepository->save($user, true);
            $security->login($user);
            $this->addFlash('info', 'Ceci est un compte admin par defaut, pensez à changer le mot de passe');
        } elseif ($checkUser->getEmail() == 'admin@ice.cd') {
            $security->login($checkUser);
            $this->addFlash('info', 'Ceci est un compte admin par defaut, pensez à changer le mot de passe');
        }

        $checkAnnee = $anneeAcademiqueRepository->findOneBy(['isEnCours'=>true]);
        if (!$checkAnnee) {
            $this->addFlash('danger', 'Configurer l\' année de travail courante en priorité.... ');
            return $this->redirectToRoute('app_annee_academique_new');
        }else{
            if(!$session->get('anneeEnCours',[])){
                $session->set('anneeEncours',$checkAnnee);
            }
        }
        $checkEntreprise = $entrepriseRepository->findOneBy([]);
        if (!$checkEntreprise) {
            $this->addFlash('danger', 'Configurer votre organisation en premier ');
            return $this->redirectToRoute('app_entreprise_new');
        }
        $checkConf = $promotionConcreteRepository->findOneBy([]);
        if (!$checkConf) {
            $this->addFlash('danger', 'Configurer Les éléments système, notamment les classes annuelles.');
            return $this->redirectToRoute('app_promotion_concrete_new');
        }

        return $this->redirectToRoute('app_promotion_concrete_index', [], Response::HTTP_SEE_OTHER);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
