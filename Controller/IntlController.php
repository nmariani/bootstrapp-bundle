<?php

namespace nmariani\Bundle\BootstrappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Locale\Locale;

class IntlController extends Controller
{

    public function localesAction($route, $routeParams, $locale=null)
    {
        if(empty($locale)) {
            $locale = \Locale::getDefault();
        }

        if(is_string($routeParams)) {
            $routeParams = json_decode($routeParams, true);
        }

        $choices = array();
        foreach($this->container->getParameter('bootstrapp.locales') as $l) {
            $choices[$l] = ucfirst(Locale::getDisplayRegion($l, $l));
        }
        asort($choices);

        return $this->render('BootstrappBundle:Navbar:locales.html.twig', array(
            'route' => $route,
            'routeParams' => $routeParams,
            'locale' => $locale,
            'locales' => $choices
        ));
    }
}
