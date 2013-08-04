<?php

namespace nmariani\Bundle\BootstrappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("elfinder")
 */
class ElFinderController extends Controller
{
    /**
     * @Route("/", name="bootstrapp_elfinder")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction() {
        return [];
    }

    /**
     * @Route("/connector", name="bootstrapp_elfinder_connector")
     * @Method({"GET", "POST"})
     */
    public function connectorAction() {
        $roots = [];
        if ($this->container->hasParameter('bootstrapp.elfinder.roots')) {
            foreach($this->container->getParameter('bootstrapp.elfinder.roots') as $root) {
                if (is_array($root)) {
                    if (!array_key_exists('driver', $root)) {
                        $root['driver'] = 'LocalFileSystem';
                    }
                    if (!array_key_exists('accessControl', $root)) {
                        $root['accessControl'] = 'access';
                    }
                    $roots[] = $root;
                }
            }
        }
        $opts = array(
            'debug' => $this->container->getParameter('kernel.debug'),
            'roots' => $roots
        );
        include_once __DIR__.'/../Resources/lib/elfinder/connector.minimal.php';
    }
}
