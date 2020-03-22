<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\PanierType;
use App\Entity\Panier;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(Request $request)
    {

        $pdo = $this->getDoctrine()->getManager();

        $produit = new Produit();

        $produits = $pdo->getRepository(Produit::class)->findAll();

        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $fichier = $form->get('photoUpload')->getData();

            if ($fichier) {
                $nomFichier = uniqid() .'.'. $fichier->guessExtension();

                try{
                    $fichier->move(
                        $this->getParameter('upload_dir'),
                        $nomFichier);
                }

            
            catch(FileException $e){

                $this->addFlash('danger', "Impossible upload fichier");
                return $this->redirectToRoute('home');
            }
            }

        }

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form_ajout' => $form->createView(),
        ]);
    }

     /**
     * @Route("/produit/{id}", name="un_produit")
     */

    public function modif(produit $produit=null, $id,  Request $request){

        $pdo = $this->getDoctrine()->getManager();

        
        $panier = new Panier();

        $produit = $this->getDoctrine()
        ->getRepository(Produit::class)
        ->find($id);


        $form = $this->createForm(PanierType::class, $panier);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $panier = $form->getData();
            $panier->setProduit($produit);
            $pdo->persist($panier);
            $pdo->flush();
        }

        $paniers = $pdo->getRepository(Panier::class)->findAll();


        return $this->render('produit/produit.html.twig', [
            'paniers' => $paniers,
            'form_ajout' => $form->createView(),
            'produit' => $produit,
        ]);

        }

    /**
     * @Route ("produit/delete/{id}", name="delete_produit")
     */

    public function delete(Produit $produit=null){

        if($produit !=null){

            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($produit);
            $pdo->flush();
        }
        return $this->redirectToRoute('produit');
    }

   


}
