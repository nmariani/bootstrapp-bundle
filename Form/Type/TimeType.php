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

use Symfony\Component\Form\Extension\Core\Type\TimeType as BaseTimeType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class TimeType extends BaseTimeType
{
    /**
     * @var string
     */
    private $widget;
    /**
     * @var string|int
     */
    private $format = \IntlDateFormatter::SHORT;
    /**
     * @var \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        switch($options['widget']) {
            case 'single_text':
            case 'text':
            case 'choice':
                break;
            default:
                $options['widget'] = 'single_text';
                break;
        }
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        switch($options['widget']) {
            case 'single_text':
            case 'text':
            case 'choice':
                break;
            default:
                $view->vars['attr']['data-format'] = $this->getPattern($options['format']);
                if(isset($options['widget']) && $this->assetsLoader) {
                    $this->assetsLoader->addVendor($options['widget']);
                }
                break;
        }

        $view->vars['attr']['autocomplete'] = 'off';

        parent::finishView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $defaults = [
            'format'  => $this->format
        ];
        if(null!==$this->widget) {
            $defaults['widget'] = $this->widget;
        }
        $resolver->setDefaults($defaults);

        $resolver->addAllowedValues(array(
            'widget'    => array(
                'jdewit',
                'mobiscroll'
            )
        ));
    }

    /**
     * Set the default widget
     * @param string $widget
     * @return TimeType
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
     * @return TimeType
     */
    public function setDefaultFormat($format) {
        if(is_string($format) || is_int($format)) {
            $this->format = $format;
        }
        return $this;
    }

    /**
     * Set the assets loader
     * @param \mariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return TimeType
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }

    /**
     * Return date pattern for given date format
     * @param string|int $format
     * @return string
     */
    protected function getPattern($format) {
        if(is_int($format)) {
            switch($format) {
                case \IntlDateFormatter::FULL:
                case \IntlDateFormatter::LONG:
                case \IntlDateFormatter::MEDIUM:
                case \IntlDateFormatter::SHORT:
                    $formatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, (int)$format);
                    break;
                default:
                    $formatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, \IntlDateFormatter::MEDIUM);
                    break;
            }
            $format = $formatter->getPattern();
        }
        return $format;
    }
}
