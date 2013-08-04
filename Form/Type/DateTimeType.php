<?php
/**
 * (c) 2012 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani
 * @date 04/12/12 17:50
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType as BaseDateTimeType,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class DateTimeType extends BaseDateTimeType
{
    /**
     * @var string
     */
    private $widget;
    /**
     * @var nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $defaults = [];
        if(null!==$this->widget) {
            $defaults['widget'] = $this->widget;
        }
        $resolver->setDefaults($defaults);

        $resolver->addAllowedValues(array(
            'date_widget' => array(
                'eyecon',
                'jqueryui',
                'mobiscroll',
                'pickadate',
            ),
            'time_widget' => array(
                'jdewit',
                'mobiscroll'
            ),
            // This option will overwrite "date_widget" and "time_widget" options
            'widget'     => array(
                'mobiscroll'
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        switch($options['widget']) {
            case 'single_text':
            case 'text':
            case 'choice':
                break;
            default:
                if(isset($options['widget']) && $this->assetsLoader) {
                    switch($options['widget']) {
                        case 'jqueryui':
                            $components = ['datepicker'];
                            break;
                        default:
                            $components = [];
                            break;
                    }
                    $this->assetsLoader->addVendor($options['widget'], $components);
                }
                break;
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
     * @param nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return DateTimeType
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }
}
