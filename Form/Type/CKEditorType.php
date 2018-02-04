<?php
/**
 * This file is part of the bootstrapp project.
 
 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 01/10/13 11:30
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

class CKEditorType extends AbstractType
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @var \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(ContainerInterface $container) {
        $this->container= $container;
        return $this;
    }

    /**
     * Set the assets loader
     * @param \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return $this
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('enable', $options['enable']);
        if ($builder->getAttribute('enable')) {
            $builder->setAttribute('base_path', $options['base_path']);

            $configs = $this->container->getParameter('bootstrapp.ckeditor.configs');
            $config = $options['config'];
            $configName = $options['config_name'];
            if (null === $configName) {
                $configName = uniqid('bootstrapp', true);
            }
            if (array_key_exists($configName, $config)) {
                $configs[$configName] = array_merge($configs[$configName], $config);
            } else {
                $configs[$configName] = $config;
            }

            $builder->setAttribute('config', $configs[$configName]);
            $builder->setAttribute('plugins', $options['plugins']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['enable'] = $form->getConfig()->getAttribute('enable');
        if ($form->getConfig()->getAttribute('enable')) {
            $view->vars['base_path'] = $form->getConfig()->getAttribute('base_path');
            $view->vars['config'] = json_encode($form->getConfig()->getAttribute('config'));
            $view->vars['plugins'] = $form->getConfig()->getAttribute('plugins');
        }
        parent::buildView($view, $form, $options);

        // Dynamically load CKEditor assets
        if($this->assetsLoader) {
            $this->assetsLoader->addVendor('ckeditor');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'enable'        => $this->container->getParameter('bootstrapp.ckeditor.enable'),
            'base_path'     => $this->container->getParameter('bootstrapp.ckeditor.base_path'),
            'config_name'   => $this->container->getParameter('bootstrapp.ckeditor.default_config'),
            'config'        => array(),
            'plugins'       => array(),
        ));

        $resolver->addAllowedTypes(array(
            'enable' => 'bool',
            'config_name' => array('string', 'null'),
            'base_path' => array('string'),
            'config' => 'array',
            'plugins' => 'array',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bootstrapp_bundle_ckeditor';
    }
}
