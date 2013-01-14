<?php

namespace nmariani\Bundle\BootstrappBundle\Tests\Controller;

require __DIR__ . '/../../../../../../../../app/autoload.php';

use atoum\AtoumBundle\Test\Units\WebTestCase;
use atoum\AtoumBundle\Test\Controller\ControllerTest;

class DocController extends ControllerTest
{
    public function testIndex()
    {
        $this
            ->request(array('debug' => true))
            ->GET('/en_US/bootstrapp/' . uniqid())
            ->hasStatus(404)
            ->hasCharset('UTF-8')
            ->hasVersion('1.1')
            ->GET('/en_US/bootstrapp/demo')
            ->hasStatus(200)
            ->hasHeader('Content-Type', 'text/html; charset=UTF-8')
            ->crawler
            ->hasElement('h1')
            ->withContent('Bootstrapp demo')
            ->end()
            ->GET('/en_US/bootstrapp/demo/eyecon')
            ->hasStatus(200)
            ->hasHeader('Content-Type', 'text/html; charset=UTF-8')
            ->crawler
            ->hasElement('#form_datetime')
            ->withAttribute('data-type', 'datetime')
            ->hasChild('#form_datetime_date')
            ->withAttribute('class', 'bootstrapp-datetime')
            ->end()
        ;
    }
}
