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

        $locales = $this->container->getParameter('bootstrapp.locales');
        $choices = [];

        switch($this->container->getParameter('bootstrapp.locales_display')) {
            case 'dialect':
                $dialects = [];
                foreach ($locales as $locale) {
                    $lang = substr($locale, 0, 2);
                    if (!isset($dialects[$lang])) {
                        $dialects[$lang] = 1;
                    } else {
                        $dialects[$lang]++;
                    }
                }
                foreach($locales as $l) {
                    $lang = substr($l, 0, 2);
                    $region = strlen($l) > 2 && $dialects[$lang] > 1 ? substr($l, -2) : null;
                    $choices[$l] = ucfirst(Intl::getLanguageBundle()->getLanguageName($lang, $region, $l));
                }
                break;
            case 'language':
                foreach($locales as $l) {
                    $choices[$l] = ucfirst(Intl::getLanguageBundle()->getLanguageName(substr($l, 0, 2), null, $l));
                }
                break;
            default:
                foreach($locales as $l) {
                    $choices[$l] = ucfirst(Intl::getLocaleBundle()->getLocaleName($l, $l));
                }
                break;
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
