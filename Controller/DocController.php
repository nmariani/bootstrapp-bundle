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
            $form->submit($request);
            if (!$form->isValid()) {
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
            $form->submit($request);
            if (!$form->isValid()) {
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
            $form->submit($request);
            if (!$form->isValid()) {
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
            $form->submit($request);
            if (!$form->isValid()) {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/ckeditor", name="bootstrapp_ckeditor")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:editor/ckeditor.html.twig")
     */
    public function ckeditorAction() {
        $values = array(
            'article'=> ''
        );

        $form = $this->createFormBuilder($values)
            ->add('article', 'bootstrapp_bundle_ckeditor')
            ->getForm();

        $request = $this->getRequest();
        if($request->isMethod('POST')) {
            $form->submit($request);
            if (!$form->isValid()) {
                $this->get('session')->getFlashBag()->add('error', $form->getErrorsAsString());
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/demo/redactor", name="bootstrapp_redactor")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:editor/redactor.html.twig")
     */
    public function redactorAction() {
        return array(
        );
    }

    /**
     * @Route("/demo/fontawesome", name="bootstrapp_fontawesome")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:icon/fontawesome.html.twig")
     */
    public function fontawesomeAction() {
        $less = file_get_contents(__DIR__.'/../Resources/public/less/icons/demo/fontawesome.less');
        preg_match_all('/icon-\S*/', $less, $matches, PREG_PATTERN_ORDER);
        return array(
            'icons' => $matches[0]
        );
    }

    /**
     * @Route("/demo/select2", name="bootstrapp_select2")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:form/select2.html.twig")
     */
    public function select2Action() {
        return array(
        );
    }

    /**
     * @Route("/demo/elfinder", name="bootstrapp_elfinder_demo")
     * @Method({"GET", "Post"})
     * @Template("BootstrappBundle:Doc:file/elfinder.html.twig")
     */
    public function elfinderAction() {
        return array(
        );
    }
}
