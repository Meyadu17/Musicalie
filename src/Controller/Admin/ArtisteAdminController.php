<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/artiste', name: 'app_admin_artiste')]
class ArtisteAdminController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(ArtisteRepository $artisteRepository): Response{
        return $this->render('admin/artiste_admin/index.html.twig', [
            'artistes' => $artisteRepository->findAll()
        ]);
    }

    //Attention à l'import du request : HttpFoundation
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           ArtisteRepository $artisteRepository,
                           int $id = null):Response
    {
        if($id == null){
            //Si id null, c'est que l'on créer le bien
            $artiste = new Artiste();
        }else{
            //S'il existe, on est dans le cas de la modification
            $artiste = $artisteRepository->find($id);
        }

        $form = $this->createForm(ArtisteType::class, $artiste);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid()) {
            //traitement des données
            $entityManager->persist($artiste); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            $this->addFlash(
                'success',
                "l'artiste a bien été édité !"
            );

            return $this->redirectToRoute('app_admin_artiste_lister');

        }

        return  $this->render('admin/artiste_admin/editer.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             ArtisteRepository $artisteRepository,
                             int $id):Response
    {

        //S'il existe, on est dans le cas de la modification
        $artiste = $artisteRepository->find($id);

        //traitement des données
        $entityManager->remove($artiste); //sauvegarde le bien
        $entityManager->flush(); //enregistre en base

        $this->addFlash(
            'success',
            'Objet supprimé avec succès');

        return  $this->redirectToRoute('app_admin_artiste_lister');
    }
}
