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
        $opts = array(
            // 'debug' => true,
            'roots' => array(
                array(
                    'driver'        => 'LocalFileSystem',                                               // driver for accessing file system (REQUIRED)
                    'path'          => realpath($this->get('kernel')->getRootDir().'/../web/files/'),   // path to files (REQUIRED)
                    'URL'           => '/files/',                                                       // URL to files (REQUIRED)starting files (OPTIONAL)
                )
            )
        );
        include_once __DIR__.'/../Resources/lib/elfinder/connector.minimal.php';
    }
}
