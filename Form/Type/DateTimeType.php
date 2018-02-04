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
use Symfony\Component\OptionsResolver\OptionsResolver;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class DateTimeType extends BaseDateTimeType
{
    /**
     * @var string
     */
    private $widget;
    /**
     * @var string|int
     */
    private $format;
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

        $defaults = [];
        if(null!==$this->widget) {
            $defaults['widget'] = $this->widget;
        }
        if(null!==$this->format) {
            $defaults['format'] = $this->format;
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
                    $this->assetsLoader->addVendor($options['widget'], ['components' => $components]);
                }
                break;
        }

        parent::buildView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bootstrapp_bundle_datetime';
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
     * Set the default format
     * @param string|int $format
     * @return DateTimeType
     */
    public function setDefaultFormat($format = null) {
        if(is_string($format) || is_int($format)) {
            $this->format = $format;
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
