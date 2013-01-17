<?php
/**
 * (c) 2013 Alitheon SAS
 *
 * @author nmariani
 * @date 17/01/13 17:24
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nmariani\Bundle\BootstrappBundle\Menu\Renderer;

use Knp\Menu\ItemInterface;
use Knp\Menu\Renderer\TwigRenderer as BaseRenderer;

class TwigRenderer extends BaseRenderer
{
    public function render(ItemInterface $item, array $options = array())
    {
        $options = array_merge(
            array('currentClass' => 'active'),
            $options
        );

        if ('root' === $item->getName()) {
            $item->setChildrenAttribute('class', trim('nav '.$item->getAttribute('class')));
        }

        return parent::render($item, $options);
    }
}
