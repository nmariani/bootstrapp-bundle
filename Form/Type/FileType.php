<?php
/**
 * This file is part of the Bootstrapp project.

 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 31/10/13 02:13
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace nmariani\Bundle\BootstrappBundle\Form\Type;

use nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader;
use Symfony\Component\Form\Extension\Core\Type\FileType as BaseFileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

use Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends BaseFileType
{
    /**
     * @var \nmariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader
     */
    private $assetsLoader;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Set the assets loader
     * @param \mariani\Bundle\BootstrappBundle\Templating\Loader\AssetsLoader $loader
     * @return TimeType
     */
    public function setAssetsLoader(AssetsLoader $loader) {
        $this->assetsLoader= $loader;
        return $this;
    }

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->setAttribute('uploadtype', $options['uploadtype']);
        $builder->setAttribute('placeholdWidth', $options['placeholdWidth']);
        $builder->setAttribute('placeholdHeight', $options['placeholdHeight']);
        $builder->setAttribute('placeholdText', $options['placeholdText']);
        $builder->setAttribute('pattern', $options['pattern']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $data = $form->getData();
        if (is_string($data)) {
            $data = [
                'filename' => basename($data),
                'url' => $data
            ];
        }
        if (is_array($data)) {
            if (!isset($view->var['url']) && isset($data['url'])) {
                $view->vars['url'] = $data['url'];
            }
            if (!isset($view->var['filename']) && isset($data['filename'])) {
                $view->vars['filename'] = $data['filename'];
            }
        }
        // autodetect type of upload
        $uploadtype = $form->getConfig()->getAttribute('uploadtype');
        if (isset($view->vars['filename'])) {
            $file = new File($view->vars['filename'], false);
            $view->vars['filetype'] = $file->getExtension();
            switch ($file->getExtension()) {
                case 'png':
                case 'jpg':
                case 'jpeg':
                case 'gif':
                    $uploadtype = 'image';
                    break;
                case 'mp4':
                    $uploadtype = 'video';
                    break;
                case 'mp3':
                case 'm4v':
                    $uploadtype = 'audio';
                    break;
                default:
                    break;
            }
        }
        $view->vars['uploadtype'] = $uploadtype;
        $view->vars['placeholdWidth'] = $form->getConfig()->getAttribute('placeholdWidth');
        $view->vars['placeholdHeight'] = $form->getConfig()->getAttribute('placeholdHeight');
        $view->vars['placeholdText'] = $form->getConfig()->getAttribute('placeholdText');

        $pattern = $options['pattern'];
        if($pattern != null) {
            if(!$this->container->hasParameter($pattern)) {
                throw new \Exception('You must define an existing pattern');
            }
            $patternSize = $this->container->getParameter($pattern);
            $view->vars['label'] .= ' (Max width: ' . $patternSize['width'] . ', Max height: ' . $patternSize['height'] . ')';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $this->assetsLoader->addVendor('fileinput');
        parent::finishView($view, $form, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $defaults = [];
        $defaults['uploadtype'] = 'file';
        $defaults['placeholdWidth'] = 300;
        $defaults['placeholdHeight'] = 300;
        $defaults['placeholdText'] = 'Upload a file';

        $resolver->setDefaults($defaults);
    }
}
