<?php
/**
 * (c) 2012 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani
 * @date 18/12/12 18:21
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nmariani\Bundle\BootstrappBundle\Templating\Loader;

class AssetsLoader
{
    /**
     * @var array
     */
    protected $vendors = [];

    /**
     * Add vendor to vendors list
     * @param string $vendor
     * @return AssetsLoader
     * @throws \InvalidArgumentException
     */
    public function addVendor($vendor)
    {
        if(!is_string($vendor)) {
            throw new \InvalidArgumentException('Vendor name should be a valid string!');
        }
        if(!in_array($vendor, $this->vendors)) {
            $this->vendors[] = $vendor;
        }
        return $this;
    }

    /**
     * Return vendors as array
     * @return array
     */
    public function getVendors()
    {
        return $this->vendors;
    }
}
