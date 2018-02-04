<?php
/**
 * This file is part of the Bootstrapp project.
 
 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 20/08/13 15:32
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. 
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType as BaseChoiceType,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class ChoiceType extends BaseChoiceType
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
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $defaults = [
            'widget' => $this->widget
        ];
        $resolver->setDefaults($defaults);

        $resolver->addAllowedValues(array(
            'widget'     => array(
                'select2'
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        switch($options['widget']) {
            case 'select2':
                if($this->assetsLoader) {
                    $this->assetsLoader->addVendor($options['widget']);
                }
                break;
            default:
                break;
        }

        parent::buildView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bootstrapp_bundle_choice';
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
}
