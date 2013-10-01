<?php

namespace nmariani\Bundle\BootstrappBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BootstrappExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // register twig form fields
        $twigFormResources = $container->hasParameter('twig.form.resources')
            ? $container->getParameter('twig.form.resources')
            : array();
        $container->setParameter(
            'twig.form.resources',
            array_merge($twigFormResources, array('BootstrappBundle:Form:fields.html.twig'))
        );

        if (isset($config['ckeditor'])) {
            $this->registerCKEditor($config['ckeditor'], $container);
        }
    }

    /**
     * Register CKEditor configuration
     *
     * @param array $config The CKEditor configuration
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container The container
    */
    protected function registerCKEditor(array $config, ContainerBuilder $container)
    {
        $container->setParameter('bootstrapp.ckeditor.enable', $config['enable']);
        $container->setParameter('bootstrapp.ckeditor.base_path', $config['base_path']);

        if ($config['enable']) {
            // manage configs
            // merge toolbars
            $toolbars = array();
            $toolbarConfigs = array_merge($this->getCKEditorDefaultToolbars(), $config['toolbars']['configs']);
            foreach ($toolbarConfigs as $name => $toolbar) {
                $toolbars[$name] = array();
                foreach ($toolbar as $item) {
                    if (is_string($item) && ($item[0] === '@')) {
                        $itemName = substr($item, 1);
                        if (!isset($config['toolbars']['items'][$itemName])) {
                            throw new \Exception(sprintf('The toolbar item "%s" does not exist.', $itemName));
                        }
                        $item = $config['toolbars']['items'][$itemName];
                    }
                    $toolbars[$name][] = $item;
                }
            }
            if (empty($config['configs'])) {
                foreach($toolbars as $name => $toolbar) {
                    $config['configs'][$name]['toolbar'] = $toolbar;
                }
            } else {
                foreach ($config['configs'] as $name => $configuration) {
                    if (isset($configuration['toolbar']) && is_string($configuration['toolbar'])) {
                        if (!isset($toolbars[$configuration['toolbar']])) {
                            throw new \Exception(sprintf('The toolbar "%s" does not exist.', $configuration['toolbar']));
                        }
                        $config['configs'][$name]['toolbar'] = $toolbars[$configuration['toolbar']];
                    }
                }
            }
            unset($config['toolbars']);

            // set configs
            $container->setParameter('bootstrapp.ckeditor.configs', $config['configs']);

            // set default config
            if (isset($config['default_config'])) {
                if (!isset($config['configs'][$config['default_config']])) {
                    throw new \Exception(sprintf('The default config "%s" does not exist.', $config['default_config']));
                }
                $container->setParameter('bootstrapp.ckeditor.default_config', $config['default_config']);
            }

            // manage plugins
            if (!empty($config['plugins'])) {
                $container->setParameter('bootstrapp.ckeditor.plugins', $config['plugins']);
            }
        }
    }

    /**
     * Gets CKEditor default toolbars.
     *
     * @return array The default toolbars.
    */
    protected function getCKEditorDefaultToolbars()
    {
        return array(
            'full' => array(
                array('Source', '-', 'NewPage', 'Preview', 'Print', '-', 'Templates'),
                array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                array('Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'),
                array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'SelectField', 'Button', 'ImageButton', 'HiddenField'),
                '/',
                array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'),
                array('Link', 'Unlink', 'Anchor'),
                array('Image', 'FLash', 'Table', 'HorizontalRule', 'SpecialChar', 'Smiley', 'PageBreak', 'Iframe'),
                '/',
                array('Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'),
                array('Maximize', 'ShowBlocks'),
                array('About'),
            ),
            'standard' => array(
                array('Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                array('Scayt'),
                array('Link', 'Unlink', 'Anchor'),
                array('Image', 'Table', 'HorizontalRule', 'SpecialChar'),
                array('Maximize'),
                array('Source'),
                '/',
                array('Bold', 'Italic', 'Strike', '-', 'RemoveFormat'),
                array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote'),
                array('Styles', 'Format', 'About'),
            ),
            'basic' => array(
                array('Bold', 'Italic'),
                array('NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'),
                array('Link', 'Unlink'),
                array('About'),
            ),
        );
    }
}
