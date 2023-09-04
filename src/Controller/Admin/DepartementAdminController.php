<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Departement;
use App\Form\BienType;
use App\Form\DepartementType;
use App\Repository\BienRepository;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/departement', name: 'app_admin_departement')]
class DepartementAdminController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(DepartementRepository $departementRepository): Response{
        return $this->render('admin/departement_admin/index.html.twig', [
            'departements' => $departementRepository->findAll()
        ]);
    }

    //Attention à l'import du request : HttpFoundation
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           DepartementRepository $departementRepository,
                           int $id = null):Response
    {
        if($id == null){
            //Si id null, c'est que l'on créer le bien
            $departement = new Departement();
        }else{
            //S'il existe, on est dans le cas de la modification
            $departement = $departementRepository->find($id);
        }

        $form = $this->createForm(DepartementType::class, $departement);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid()) {
            //traitement des données
            $entityManager->persist($departement); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            $this->addFlash(
                'success',
                'le département a bien été édité !'
            );

            return $this->redirectToRoute('app_admin_departement_lister');

        }

        return  $this->render('admin/departement_admin/editer.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             DepartementRepository $departementRepository,
                             int $id):Response
    {

        //S'il existe, on est dans le cas de la modification
        $departement = $departementRepository->find($id);

        //traitement des données
        $entityManager->remove($departement); //sauvegarde le bien
        $entityManager->flush(); //enregistre en base

        $this->addFlash(
            'success',
            'Objet supprimé avec succès');

        return  $this->redirectToRoute('app_admin_departement_lister');
    }
}
