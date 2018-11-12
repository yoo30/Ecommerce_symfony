<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\Advert2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProduitsController extends Controller

{

    public function produitsAction(Request $request)

    {

        $em = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('EcommerceEcommerceBundle:Advert2');

        $listProduits = $em->findAll();


        return $this->render('EcommerceEcommerceBundle:Default:produits/layout/produits.html.twig', array('listProduits' => $listProduits));

    }



      public function presentationAction($id)

    {

        $em = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('EcommerceEcommerceBundle:Advert2');

        $produit = $em->find($id);

        if (null === $produit)
          {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
          }


        return $this->render('EcommerceEcommerceBundle:Default:produits/layout/presentation.html.twig',
            array('produit' => $produit ));

    }



    public function addProduitsAction(Request $request)

    {
         // Création de l'entité
        $produit = new Advert2();
        $produit->setNom('Essai');
        $produit->setDescription('La grenade est le fruit du grenadier (Punica granatum) de la famille des Lythracées. Elle provient d\'un domaine qui s\'étend de l\'Asie occidentale à l\'Asie ... ');
        $produit->setPrix(100.00);

        $em = $this->getDoctrine()->getManager();

        $em->persist($produit);

        $em->flush();

        return $this->render('EcommerceEcommerceBundle:Default:panier/layout/panier.html.twig');
    }


}
