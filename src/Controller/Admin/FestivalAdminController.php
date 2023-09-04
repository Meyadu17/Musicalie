<?php

namespace App\Controller\Admin;

use App\Entity\Festival;
use App\Form\FestivalType;
use App\Repository\FestivalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/festival', name: 'app_admin_festival')]
class FestivalAdminController extends AbstractController
{
    #[Route('/', name: '_lister')]
    public function lister(FestivalRepository $festivalRepository): Response{
        return $this->render('admin/festival_admin/index.html.twig', [
            'festivals' => $festivalRepository->findAll()
        ]);
    }

    //Attention à l'import du request : HttpFoundation
    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request,
                           EntityManagerInterface $entityManager,
                           FestivalRepository $festivalRepository,
                           int $id = null):Response
    {
        if($id == null){
            //Si id null, c'est que l'on créer le bien
            $festival = new Festival();
            $festival->setDateCreation(new \DateTime());
        }else{
            //S'il existe, on est dans le cas de la modification
            $festival = $festivalRepository->find($id);
        }

        $form = $this->createForm(FestivalType::class, $festival);

        //Permet de récupérer les données postées
        $form->handleRequest($request);

        //si le formulaire est soumis et est valide
        if($form->isSubmitted() && $form->isValid()) {
            //traitement des données
            $entityManager->persist($festival); //sauvegarde le bien
            $entityManager->flush(); //enregistrer en base

            $this->addFlash(
                'success',
                'Le festival a bien été édité !'
            );

            return $this->redirectToRoute('app_admin_festival_lister');

        }

        return  $this->render('admin/festival_admin/editer.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function suprimer(EntityManagerInterface $entityManager,
                             FestivalRepository $festivalRepository,
                             int $id):Response
    {

        //S'il existe, on est dans le cas de la modification
        $festival = $festivalRepository->find($id);

        //traitement des données
        $entityManager->remove($festival); //sauvegarde le bien
        $entityManager->flush(); //enregistre en base

        $this->addFlash(
            'success',
            'Objet supprimé avec succès');

        return  $this->redirectToRoute('app_admin_festival_lister');
    }
}
