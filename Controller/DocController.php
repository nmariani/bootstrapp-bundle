<?php

namespace nmariani\Bundle\BootstrappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("bootstrapp")
 */
class DocController extends Controller
{
    /**
     * @Route("/", name="bootstrapp_readme")
     * @Method({"GET"})
     * @Template("BootstrappBundle:Doc:readme.html.twig")
     */
    public function readmeAction() {
        return array(
        );
    }

    /**
     * @Route("/demo", name="bootstrapp_demo")
     * @Method({"GET"})
     * @Template("BootstrappBundle:Doc:demo.html.twig")
     */
    public function demoAction() {
        return array(
        );
    }

    /**
     * @Route("/demo/eyecon", name="bootstrapp_eyecon")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:datetime/eyecon.html.twig")
     */
    public function eyeconAction() {
        $now = new \DateTime();
        $values = array(
            'sdate'=> $now,
            'mdate'=> $now,
            'ldate'=> $now,
            'fdate'=> $now,
            'ddate'=> $now,
            'cdate'=> $now,
            'datetime'=> $now
        );

        $form = $this->createFormBuilder($values)
            ->add('sdate', 'date', ['label' => 'A short date field', 'widget' => 'eyecon', 'format'=> \IntlDateFormatter::SHORT])
            ->add('mdate', 'date', ['label' => 'A medium date field', 'widget' => 'eyecon', 'format'=> \IntlDateFormatter::MEDIUM])
            ->add('ldate', 'date', ['label' => 'A long date field', 'widget' => 'eyecon', 'format'=> \IntlDateFormatter::LONG])
            ->add('fdate', 'date', ['label' => 'A full date field', 'widget' => 'eyecon', 'format'=> \IntlDateFormatter::FULL])
            ->add('ddate', 'date', ['label' => 'A default date field', 'widget' => 'eyecon'])
            ->add('cdate', 'date', ['label' => 'A custom date field (EEEE, d.M.y)', 'widget' => 'eyecon', 'format'=> 'EEEE, d.M.y'])
            ->add('datetime', 'datetime', ['label' => 'A datetime field', 'date_widget' => 'eyecon'])
            ->getForm();

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
            } else {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/pickadate", name="bootstrapp_pickadate")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:datetime/pickadate.html.twig")
     */
    public function pickadateAction() {
        $now = new \DateTime();
        $values = array(
            'date'=> $now,
            'time'=> $now,
            'datetime'=> $now,
        );

        $form = $this->createFormBuilder($values)
            ->add('date', 'date', ['widget' => 'pickadate'])
            ->add('datetime', 'datetime', ['date_widget' => 'pickadate'])
            ->getForm();

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
            } else {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/jqueryui", name="bootstrapp_jqueryui")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:datetime/jqueryui.html.twig")
     */
    public function jqueryuiAction() {
        $now = new \DateTime();
        $values = array(
            'date'=> $now,
            'time'=> $now,
            'datetime'=> $now,
        );

        $form = $this->createFormBuilder($values)
            ->add('date', 'date', ['widget' => 'jqueryui'])
            ->add('time', 'time')
            ->add('datetime', 'datetime', ['date_widget' => 'jqueryui'])
            ->getForm();

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
            } else {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/mobiscroll", name="bootstrapp_mobiscroll")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:datetime/mobiscroll.html.twig")
     */
    public function mobiscrollAction() {
        $now = new \DateTime();
        $values = array(
            'date'=> $now,
            'time'=> $now,
            'datetime'=> $now,
        );

        $form = $this->createFormBuilder($values)
            ->add('date', 'date', ['widget' => 'mobiscroll'])
            ->add('time', 'time', ['widget' => 'mobiscroll'])
            ->add('datetime', 'datetime', ['widget' => 'mobiscroll'])
            ->getForm();

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                #echo "<pre>";
                #var_dump($form->getData());
                #echo "</pre>";
            } else {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/redactor", name="text/bootstrapp_redactor")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:redactor.html.twig")
     */
    public function redactorAction() {
        return array(
        );
    }
}
