<?php
/**
 * This file is part of the Bootstrapp project.

 * (c) 2013 Nathanaël Mariani <github@nmariani.fr>
 *
 * @author nmariani <github@nmariani.fr>
 * @date 31/10/13 02:22
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace nmariani\Bundle\BootstrappBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ThumbnailExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
            new TwigFunction('placehold', 'getPlaceholdItUrl')
        );
    }

    /**
     * Generate placehold.it url
     * @param $width
     * @param null $height
     * @param string $backGroundColor
     * @param string $textColor
     * @param string $text
     * @return string
     */
    public function getPlaceholdItUrl(
        $width = 200,
        $height = null,
        $text = "",
        $backGroundColor = 'EFEFEF',
        $textColor = 'AAAAAA'
    ) {
        $url = "http://www.placehold.it";
        // width
        $url .= '/' . $width;
        // height
        if (null != $height) {
            $url .= 'x' . $height;
        }
        // $backGroundColor
        if (null != $backGroundColor) {
            $url .= '/' . $backGroundColor;
        }
        // $textColor
        if (null != $textColor) {
            $url .= '/' . $textColor;
        }
        // $text
        if (null != $text) {
            $url .= '&text=' . urlencode($text);
        }

        return $url;
    }

    public function getName()
    {
        return 'bootstrapp_thumbnail_extension';
    }
}
