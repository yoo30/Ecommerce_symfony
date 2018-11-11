<?php

namespace Choosit\PlatformBundle\Controller;

use Choosit\PlatformBundle\Entity\Advert2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;


class PanierController extends Controller

{

    public function panierAction( Request $request)
    {

         $session = $request->getSession();
         //$session->remove('panier');
        // die();

        if (!$session->has('panier')) $session->set('panier', array());

        $em = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ChoositPlatformBundle:Advert2');
        $produits = $em->findArray(array_keys($session->get('panier')));

        return $this->render('ChoositPlatformBundle:Default:panier/layout/panier.html.twig',
            array('produits' => $produits,
                    'panier' => $session->get('panier')));
    }



    public function validationAction()
    {

        return $this->render('ChoositPlatformBundle:Default:panier/layout/panier.html.twig');
    }


    public function ajouterAction($id, Request $request)
    {

         $session = $request->getSession();
        if (!$session->has('panier')) $session->set('panier', array());

        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)){   //$panier[id du produit] => quantite
            if ($request->query->get('quantite') != null)
                $panier[$id] = $request->query->get('quantite');

        }else{

            if ($request->query->get('quantite') != null)
                $panier[$id] = $request->query->get('quantite');
            else
                $panier[$id] = 1;
        }

        $session->set('panier',$panier);
        $this->get('session')->getFlashBag()->add('success', 'Article(s) ajouté(s) avec succés');
        return $this->redirect($this->generateUrl('panier'));
    }



    public function supprimerAction($id, Request $request)

    {

        $session = $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]); //suppression de l element du tableau
            $session->set('panier', $panier);
            $this->get('session')->getFlashBag()->add('success', 'Article supprimé avec succés');
        }

        return $this->redirect($this->generateUrl('panier'));
    }


    public function menuAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $this->render('ChoositPlatformBundle:Default:panier/layout/modulesUsed/module.html.twig',
            array('articles', $articles));

    }


    public function viderAction(Request $request)
    {

       $session = $request->getSession();

        $session->remove('panier');

        return $this->redirect($this->generateUrl('panier'));
    }


}
