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

use Symfony\Component\Form\Extension\Core\Type\DateType as BaseDateType,
    Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;

class DateType extends BaseDateType
{
    /**
     * @var string
     */
    private $widget;
    /**
     * @var string|int
     */
    private $format = self::HTML5_FORMAT; // 'yyyy-MM-dd'
    /**
     * @var nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
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

        parent::finishView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $defaults = [
            'format'  => $this->format,
            'compound' => function(Options $options){return $this->isCompound($options);}
        ];
        if(null!==$this->widget) {
            $defaults['widget'] = $this->widget;
        }
        $resolver->setDefaults($defaults);

        $resolver->addAllowedValues(array(
            'widget'    => array(
                'eyecon',
                'jqueryui',
                'mobiscroll',
                'pickadate',
            )
        ));
    }

    /**
     * Set the default widget
     * @param string $widget
     * @return DateType
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
     * @return DateType
     */
    public function setDefaultFormat($format) {
        if(is_string($format) || is_int($format)) {
            $this->format = $format;
        }
        return $this;
    }

    /**
     * Set the assets loader
     * @param nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return DateType
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
                    $formatter = new \IntlDateFormatter(\Locale::getDefault(), (int)$format, \IntlDateFormatter::NONE);
                    $format = $formatter->getPattern();
                    break;
                default:
                    break;
            }
        }
        return $format;
    }

    /**
     * Return true is given options match a compound widget, else return false
     * @param \Symfony\Component\OptionsResolver\Options $options
     * @return bool
     */
    protected function isCompound(Options $options) {
        return in_array($options['widget'], ['text', 'choice']);
    }
}
