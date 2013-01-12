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

namespace nmariani\Bundle\BootstrappBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContainerTest extends WebTestCase
{
    public function testGetParameters() {
        $container = static::$kernel->getContainer();

        $locales = $container->getParameter('bootstrapp.locales');

        foreach($locales as $locale) {
            $this->assertRegExp('/^[a-z]{2]_[A-Z]{2}$/', $locale);
        }
    }
}
