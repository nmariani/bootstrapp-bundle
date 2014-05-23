<?php

namespace nmariani\Bundle\BootstrappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Intl\Intl;
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

        $display = $this->container->getParameter('bootstrapp.locales_display');

        $choices = array();
        foreach($this->container->getParameter('bootstrapp.locales') as $l) {
            switch ($display) {
                case 'language':
                    $lang = substr($l, 0, 2);
                    $region = strlen($l) > 2 ? substr($l, -2) : null;
                    $choices[$l] = ucfirst(Intl::getLanguageBundle()->getLanguageName($lang, $region, $l));
                    break;
                default:
                    $choices[$l] = ucfirst(Intl::getLocaleBundle()->getLocaleName($l, $l));
                    break;
            }
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
