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


use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class LocationType  extends AbstractType
{
    /**
     * @var string
     */
    private $widget;

    /**
     * @var \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address')
            ->add('latitude', 'number', ['precision' => 6, 'grouping' => true])
            ->add('longitude', 'number', ['precision' => 6, 'grouping' => true])
            ->add('streetNumber', 'text', array(
                    'label' => 'N°',
                    'required' => false
                )
            )
            ->add('route', 'text', array(
                    'label' => 'Route',
                    'required' => false
                )
            )
            ->add('postalCode', 'text', array(
                    'label' => 'Postal code',
                    'required' => false
                )
            )
            ->add('locality')
            ->add('shortCountry', 'country', array(
                    'preferred_choices' => array('FR'),
                    'required' => false,
                    'label' => 'Country'
                )
            )
            ->add('country', 'hidden')
            ->add('administrativeAreaLevel1', 'hidden')
            ->add('administrativeAreaLevel2', 'hidden')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'    => 'nmariani\Bundle\BootstrappBundle\Form\Model\Location',
            'widget'        => $this->widget
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
        }
        parent::buildView($view, $form, $options);
    }

    /**
     * Set the default widget
     * @param string $widget
     * @return DateTimeType
     */
    public function setDefaultWidget($widget) {
        if(is_string($widget)) {
            $this->widget = $widget;
        }
        return $this;
    }

    /**
     * Set the assets loader
     * @param \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return DateTimeType
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }

    public function getName()
    {
        return 'bootstrapp_bundle_location';
    }
}