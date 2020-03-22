<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Panier;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;


class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier")
     */
    public function index(Request $request)
    {
        $pdo = $this->getDoctrine()->getManager();

        $paniers = $pdo->getRepository(Panier::class)->findAll();

        $compte = count($paniers);

        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
            'size' => $compte,
        ]);
    }

    /**
     * @Route ("panier/delete/{id}", name="delete_panier")
     */

    public function delete(Panier $panier=null){

        if($panier !=null){

            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($panier);
            $pdo->flush();
        }
        return $this->redirectToRoute('panier');
    }

}
