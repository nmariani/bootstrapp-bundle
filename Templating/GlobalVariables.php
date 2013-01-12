<?php
/**
 * (c) 2012 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani
 * @date 18/12/12 18:52
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nmariani\Bundle\BootstrappBundle\Templating;

use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables as BaseVariables;

class GlobalVariables extends BaseVariables
{
    /**
     * Returns vendors
     *
     * @return array
     */
    public function getVendors()
    {
        if ($this->container->has('assets_loader') && $loader = $this->container->get('assets_loader')) {
            return $loader->getVendors();
        }
    }
}
