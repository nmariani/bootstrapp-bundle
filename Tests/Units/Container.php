<?php
/**
 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani
 * @date 11/01/13 18:30
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Tests\Units;

require __DIR__ . '/../../../../../../../../app/autoload.php';

use atoum\AtoumBundle\Test\Units;

class Container extends Units\WebTestCase
{
    public function testGetParameters() {
        $this->createClient();
        $locales = $this->kernel->getContainer()->getParameter('bootstrapp.locales');
        foreach($locales as $locale) {
            $this->string($locale)->match('#^[a-z]{2}_[A-Z]{2}$#');
        }
    }
}