<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\Festival;
use App\Repository\DepartementRepository;
use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil_lister')]
    public function lister(FestivalRepository $festivalRepository,
                            DepartementRepository $departementRepository): Response{

        return $this->render('main/accueil.html.twig', [
            'festivals' => $festivalRepository->findBy(
                [],                // Aucun critère de recherche particulier
                ['id' => 'DESC'],  // Clause 'ORDER BY' pour trier par 'id' en ordre décroissant
                3             // Limite de 3 résultats
            ),
            'departements' => $departementRepository->findAll(
                [],
                ['code' => 'ASC']
            )
        ]);
    }

    #[Route('/festival/{nom}', name: 'app_festival_voir')]
    public function voirFestival(Festival $festival):Response {

        return  $this->render('main/festival_detail.html.twig', [
            'festival' => $festival,
        ]);
    }

    #[Route('/departement/{code}', name: 'app_departement_voir')]
    public function voirDepartement(Departement $departement):Response {

        return  $this->render('main/departement_detail.html.twig', [
            'departement' => $departement,
        ]);
    }
}
