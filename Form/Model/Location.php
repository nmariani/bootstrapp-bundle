<?php
/**
 * This file is part of the Bootstrapp project.
 
 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 30/08/13 15:13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. 
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Model;

class Location {

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $latitude;

    /**
     * @var string
     */
    protected $longitude;

    /**
     * @var string
     */
    protected $streetNumber;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @var string
     */
    protected $locality;

    /**
     * @var string
     */
    protected $shortCountry;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $administrativeAreaLevel1;

    /**
     * @var string
     */
    protected $administrativeAreaLevel2;


    /**
     * Set address
     *
     * @param string $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set streetNumber
     *
     * @param string $streetNumber
     * @return Address
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * Get streetNumber
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * Set route
     *
     * @param string $route
     * @return Address
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Address
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set shortCountry
     *
     * @param string $shortCountry
     * @return Address
     */
    public function setShortCountry($shortCountry)
    {
        $this->shortCountry = $shortCountry;

        return $this;
    }

    /**
     * Get shortCountry
     *
     * @return string
     */
    public function getShortCountry()
    {
        return $this->shortCountry;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set administrativeAreaLevel1
     *
     * @param string $administrativeAreaLevel1
     * @return Address
     */
    public function setAdministrativeAreaLevel1($administrativeAreaLevel1)
    {
        $this->administrativeAreaLevel1 = $administrativeAreaLevel1;

        return $this;
    }

    /**
     * Get administrativeAreaLevel1
     *
     * @return string
     */
    public function getAdministrativeAreaLevel1()
    {
        return $this->administrativeAreaLevel1;
    }

    /**
     * Set administrativeAreaLevel2
     *
     * @param string $administrativeAreaLevel2
     * @return Address
     */
    public function setAdministrativeAreaLevel2($administrativeAreaLevel2)
    {
        $this->administrativeAreaLevel2 = $administrativeAreaLevel2;

        return $this;
    }

    /**
     * Get administrativeAreaLevel2
     *
     * @return string
     */
    public function getAdministrativeAreaLevel2()
    {
        return $this->administrativeAreaLevel2;
    }
}