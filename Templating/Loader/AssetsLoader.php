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
     * @param array $parameters
     * @return AssetsLoader
     * @throws \InvalidArgumentException
     */
    public function addVendor($vendor, $parameters = [])
    {
        if(!is_string($vendor)) {
            throw new \InvalidArgumentException('Vendor name should be a valid string!');
        }
        if(!is_array($parameters)) {
            throw new \InvalidArgumentException('Vendor parameters should be an array!');
        }
        if(!array_key_exists($vendor, $this->vendors)) {
            $this->vendors[$vendor] = $parameters;
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
