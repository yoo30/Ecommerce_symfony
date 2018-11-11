<?php


namespace Choosit\PlatformBundle\vueGeneralPanier;

class NavPanier

{

    public function menuAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('panier'))
            $articles = 0;
        else
            $articles = count($session->get('panier'));

        return $articles;

    }
}
