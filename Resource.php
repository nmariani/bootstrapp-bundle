<?php
/**
 * This file is part of the bootstrapp project.
 *
 * (c) 2014 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 29/01/2014 11:00
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. 
 */

namespace nmariani\Bundle\BootstrappBundle;


class Resource
{
    /**
     * Supported resources
     * @var array
     */
    static private $resources = [
        'Bootstrap' => [
            'versions' => ['2', '3'],
            'twig.form' => true
        ]
    ];
    /**
     * Resource name
     * @var string
     */
    protected $name;
    /**
     * Resource version
     * @var string
     */
    protected $version;
    /**
     * config
     * @var array
     */
    protected $config;


    /**
     * @param $str
     */
    static public function fromString($str)
    {
        $data = preg_split('/[~#]/', $str);
        $name = $data[0];
        $version = isset($data[1]) ? $data[1] : null;
        return new self($name, $version);
    }

    /**
     * @param string $name
     * @param string|null $version
     */
    public function __construct($name, $version = null)
    {
        if (!array_key_exists($name, self::$resources)) {
            throw new \InvalidArgumentException($name . ' is not a valid BootstrappBundle resource!');
        }

        $this->name = $name;
        $this->config = self::$resources[$name];

        if (!empty($version)) {
            if (!in_array($version, $this->config['versions'])) {
                throw new \InvalidArgumentException($name . ' version ' . $version . ' is not supported!');
            }
            $this->version = $version;
        } else {
            $versions = $this->config['versions'];
            $this->version = end($versions);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->name.$this->version;
    }

    /**
     * @return string
     */
    public function getTwigForm()
    {
        if (isset($this->config['twig.form'])) {
            if (true === $this->config['twig.form']) {
                return 'fields.html.twig';
            }
            return $this->config['twig.form'];
        }
        return false;
    }
}