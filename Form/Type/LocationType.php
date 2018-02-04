<?php
/**
 * This file is part of the Bootstrapp project.
 
 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 29/08/13 18:21
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. 
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Type;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class LocationType  extends AbstractType
{
    /**
     * @var string
     */
    private $widget;

    /**
     * @var string
     */
    private $mapApiKey;

    /**
     * @var \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     * @param ContainerInterface $container
     * @param AssetsLoader $assetsLoader
     * @param string $widget
     * @param string $mapApiKey
     */
    public function __construct(ContainerInterface $container, AssetsLoader $assetsLoader, $widget, $mapApiKey)
    {
        $this->setContainer($container);
        $this->setAssetsLoader($assetsLoader);
        $this->setDefaultWidget($widget);
        $this->setDefaultMapApiKey($mapApiKey);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = $options['fields'];
        if (!is_array($fields) || empty($fields)) {
            $fields = [
                'address',
                'streetNumber',
                'route',
                'postalCode',
                'locality',
                'shortCountry',
                'country',
                'administrativeAreaLevel1',
                'administrativeAreaLevel2',
            ];
        }

        $builder
            ->add('latitude', 'hidden')
            ->add('longitude', 'hidden')
        ;

        foreach($fields as $index => $field) {
            $params = [];
            if (is_array($field)) {
                if (isset($field['options'])) {
                    $params = $field['options'];
                }
                if (isset($field['autocomplete'])) {
                    if (!isset($params['attr'])) {
                        $params['attr'] = [];
                    }
                    $params['attr']['data-autocomplete'] = true;
                }
                $field = $index;
            }

            $opts = [];
            $type = 'text';
            switch ($field) {
                case 'address':
                    $opts = [
                        'attr' => [
                            'placeholder' => 'Please enter the address to search',
                            'data-location' => 'formatted_address',
                            'data-autocomplete' => true
                        ]
                    ];
                    break;
                case 'streetNumber':
                    $opts = [
                        'label' => 'N°',
                        'attr' => [
                            'placeholder' => 'N°',
                            'data-location' => 'street_number'
                        ],
                        'required' => false
                    ];
                    break;
                case 'route':
                    $opts = [
                        'label' => 'Route',
                        'attr' => [
                            'placeholder' => 'Route',
                            'data-location' => 'route',
                            'data-autocomplete' => true,
                            'data-restrict' => true
                        ],
                        'required' => false ];
                    break;
                case 'postalCode':
                    $opts = [
                        'label' => 'Postal code',
                        'attr' => [
                            'placeholder' => 'Postal code',
                            'data-location' => 'postal_code',
                            'data-autocomplete' => true,
                            'data-restrict' => true
                        ],
                        'required' => false
                    ];
                    break;
                case 'locality':
                    $opts = [
                        'attr' => [
                            'placeholder' => 'Locality',
                            'data-location' => 'locality',
                            'data-autocomplete' => true,
                            'data-restrict' => true
                        ]
                    ];
                    break;
                case 'shortCountry':
                    $countries = $options['preferred_countries'];
                    $country = $this->getDefaultCountry();
                    if (!in_array($country, $countries)) {
                        array_unshift($countries, $country);
                    }
                    $opts = [
                        'empty_data' => $country,
                        'preferred_choices' => $countries,
                        'required' => false,
                        'label' => 'Country',
                        'attr' => [
                            'data-location' => 'country',
                            'data-format' => 'short',
                            'data-restrict' => true
                        ]
                    ];
                    $type = 'country';
                    break;
                case 'country':
                    $type = 'hidden';
                    $opts = [
                        'attr' => [
                            'data-location' => 'country',
                            'data-format' => 'long'
                        ]
                    ];
                    break;
                case 'administrativeAreaLevel1':
                    $type = 'hidden';
                    $opts = [
                        'attr' => [
                            'data-location' => 'administrative_area_level_1',
                        ]
                    ];
                    break;
                case 'administrativeAreaLevel2':
                    $type = 'hidden';
                    $opts = [
                        'attr' => [
                            'data-location' => 'administrative_area_level_2',
                        ]
                    ];
                    break;
            }

            $opts = array_merge_recursive($opts, $params);
            $builder->add($field, $type, $opts);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class'    => 'nmariani\Bundle\BootstrappBundle\Form\Model\Location',
            'widget'        => $this->widget,
            'fields'        => [],
            'preferred_countries'   => $this->container->getParameter('form.type.location.preferred_countries'),
            'map_api_key'      => $this->mapApiKey
        ]);

        $resolver->addAllowedValues(array(
            'widget' => array(
                'location-typeahead'
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if(isset($options['widget']) && $this->assetsLoader) {
            $this->assetsLoader->addVendor($options['widget']);
            $this->assetsLoader->addVendor('select2');
            $this->assetsLoader->addVendor('gmaps', ['api_key' => $options['map_api_key']]);
        }

        $view->vars['defaultCountry'] = $this->getDefaultCountry();

        parent::buildView($view, $form, $options);
    }

    /**
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container) {
        $this->container= $container;
        return $this;
    }

    /**
     * Set the default widget
     * @param string $widget
     * @return LocationType
     */
    public function setDefaultWidget($widget) {
        if(is_string($widget)) {
            $this->widget = $widget;
        }
        return $this;
    }

    /**
     * Set the default map API key
     * @param string $key
     * @return LocationType
     */
    public function setDefaultMapApiKey($key) {
        if(is_string($key)) {
            $this->mapApiKey = $key;
        }
        return $this;
    }

    /**
     * Set the assets loader
     * @param \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return LocationType
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }

    public function getDefaultCountry()
    {
        $defaultCountry = $this->container->getParameter('form.type.location.country');
        if (false === $defaultCountry) {
            $defaultCountry = '';
        } else if (empty($defaultCountry)) {
            $defaultCountry = \Locale::getRegion($this->container->get('request')->getLocale());
        }
        return $defaultCountry;
    }

    public function getBlockPrefix()
    {
        return 'bootstrapp_bundle_location';
    }
}
