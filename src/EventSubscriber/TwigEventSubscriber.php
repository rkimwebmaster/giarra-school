<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\AnneeAcademiqueRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FraisRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twig\Environment;

class TwigEventSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private Environment $twig,
        private EntrepriseRepository $entrepriseRepository,
        private FraisRepository $fraisRepository,
        private AnneeAcademiqueRepository $anneeAcademiqueRepository,
        
    ) {
    }


    public function onKernelController(ControllerEvent $event): void
    {
        $annee=$this->anneeAcademiqueRepository->findOneBy(['isEnCours'=>true]);
        // dd($annee);
        // $entreprise=$this->entrepriseRepository->findOneBy([]);
        $this->twig->addGlobal('entreprise', $this->entrepriseRepository->findOneBy([]) );
        // $this->twig->addGlobal('fraisPaiements', $this->fraisRepository->findBy(['anneeAcademique'=>]) );
        $this->twig->addGlobal('annneeCourante', $this->anneeAcademiqueRepository->findOneBy(['isEnCours'=>true]) );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
