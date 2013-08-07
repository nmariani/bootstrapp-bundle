<?php
namespace nmariani\Bundle\BootstrappBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class AssetsInstallCommand extends ContainerAwareCommand
{
    static private $availableAssets = [
        'TwitterBootstrap',
        'TwitterCldr',
        'Entypo',
        'FontAwesome',
        'Jdewit',
        'Eternicode',
        'Vitalets',
        'Mobiscroll',
        'JQueryUI',
        'Addyosmani',
        'Pickadate',
        'Redactor',
        'ElFinder',
        'JQuerySortable',
    ];
    private $path;
    private $assets;

    protected function configure()
    {
        $this
            ->setName('bootstrapp:install')
            ->setDescription('Install bootstrapp assets into BootstrappBundle public folder')
            ->setDefinition(array(
                new InputArgument(
                    'assets',
                    InputArgument::IS_ARRAY,
                    'What do you want to install (separate multiple assets with a space) ?'
                )
            ))
            ->setHelp(<<<EOT
The <info>%command.name%</info> command install new bootstrapp assets version

  <info>php %command.full_name% [assets]</info>

You can specify an array of assets as argument or this interactive shell will ask you for these informations.
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->path = $this->getContainer()->get('kernel')->getBundle('BootstrappBundle')->getPath();
        if (empty($this->assets)) {
            $output->writeln('<comment>Installing all assets...</comment>');
            $this->assets = self::$availableAssets;
        } else {
            $output->writeln('<comment>Installing assets : ' . implode(', ', $this->assets) . '...</comment>');
        }

        if(in_array('TwitterBootstrap', $this->assets)) {
            $output->writeln('<comment>Installing Twitter Bootstrap assets...</comment>');
            if(true === $this->getTwitterBootstrapAssets($output)) {
                $output->writeln('<info>Success, Twitter Bootstrap assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Twitter Bootstrap assets installation failed!</error>');
            }
        }

        if(in_array('TwitterCldr', $this->assets)) {
            $output->writeln('<comment>Installing Twitter CLDR assets...</comment>');
            if(true === $this->getTwitterCldrAssets($output)) {
                $output->writeln('<info>Success, Twitter CLDR assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Twitter CLDR assets installation failed!</error>');
            }
        }

        if(in_array('Entypo', $this->assets)) {
            $output->writeln('<comment>Installing Entypo assets...</comment>');
            if(true === $this->getEntypoAssets($output)) {
                $output->writeln('<info>Success, Entypo assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Entypo assets installation failed!</error>');
            }
        }

        if(in_array('FontAwesome', $this->assets)) {
            $output->writeln('<comment>Installing FontAwesome assets...</comment>');
            if(true === $this->getFontAwesomeAssets($output)) {
                $output->writeln('<info>Success, FontAwesome assets installed!</info>');
            } else {
                $output->writeln('<error>Error : FontAwesome assets installation failed!</error>');
            }
        }

        if(in_array('Jdewit', $this->assets)) {
            $output->writeln('<comment>Installing jdewit assets...</comment>');
            if(true === $this->getJdewitAssets($output)) {
                $output->writeln('<info>Success, jdewit assets installed!</info>');
            } else {
                $output->writeln('<error>Error : jdewit assets installation failed!</error>');
            }
        }

        if(in_array('Eternicode', $this->assets)) {
            $output->writeln('<comment>Installing eternicode assets...</comment>');
            if(true === $this->getEternicodeAssets($output)) {
                $output->writeln('<info>Success, eternicode assets installed!</info>');
            } else {
                $output->writeln('<error>Error : eternicode assets installation failed!</error>');
            }
        }

        if(in_array('Vitalets', $this->assets)) {
            $output->writeln('<comment>Installing vitalets assets...</comment>');
            if(true === $this->getVitaletsAssets($output)) {
                $output->writeln('<info>Success, vitalets assets installed!</info>');
            } else {
                $output->writeln('<error>Error : vitalets assets installation failed!</error>');
            }
        }

        if(in_array('Mobiscroll', $this->assets)) {
            $output->writeln('<comment>Installing mobiscroll assets...</comment>');
            if(true === $this->getMobiscrollAssets($output)) {
                $output->writeln('<info>Success, mobiscroll assets installed!</info>');
            } else {
                $output->writeln('<error>Error : mobiscroll assets installation failed!</error>');
            }
        }

        if(in_array('JQueryUI', $this->assets)) {
            $output->writeln('<comment>Installing jquery-ui assets...</comment>');
            if(true === $this->getJQueryUIAssets($output)) {
                $output->writeln('<info>Success, jquery-ui assets installed!</info>');
            } else {
                $output->writeln('<error>Error : jquery-ui assets installation failed!</error>');
            }
        }

        if(in_array('Addyosmani', $this->assets)) {
            $output->writeln('<comment>Installing addyosmani assets...</comment>');
            if(true === $this->getAddyosmaniAssets($output)) {
                $output->writeln('<info>Success, addyosmani assets installed!</info>');
            } else {
                $output->writeln('<error>Error : addyosmani assets installation failed!</error>');
            }
        }

        if(in_array('Pickadate', $this->assets)) {
            $output->writeln('<comment>Installing pickadate assets...</comment>');
            if(true === $this->getPickadateAssets($output)) {
                $output->writeln('<info>Success, pickadate assets installed!</info>');
            } else {
                $output->writeln('<error>Error : pickadate assets installation failed!</error>');
            }
        }

        if(in_array('Redactor', $this->assets)) {
            $output->writeln('<comment>Installing redactor assets...</comment>');
            if(true === $this->getRedactorAssets($output)) {
                $output->writeln('<info>Success, redactor assets installed!</info>');
            } else {
                $output->writeln('<error>Error : redactor assets installation failed!</error>');
            }
        }

        if(in_array('ElFinder', $this->assets)) {
            $output->writeln('<comment>Installing elFinder assets...</comment>');
            if(true === $this->getElFinderAssets($output)) {
                $output->writeln('<info>Success, elFinder installed!</info>');
            } else {
                $output->writeln('<error>Error : elFinder installation failed!</error>');
            }
        }

        if(in_array('JQuerySortable', $this->assets)) {
            $output->writeln('<comment>Installing jQuery Sortable assets...</comment>');
            if(true === $this->getJQuerySortableAssets($output)) {
                $output->writeln('<info>Success, jQuery Sortable assets installed!</info>');
            } else {
                $output->writeln('<error>Error : jQuery Sortable assets installation failed!</error>');
            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->assets = array_intersect($input->getArgument('assets'), self::$availableAssets);
        if (empty($this->assets)) {
            $dialog = $this->getHelper('dialog');
            if (!$dialog->askConfirmation(
                    $output,
                    '<question>Install all assets ?</question>',
                    false
                )) {
                $choices = self::$availableAssets;
                $selected = $dialog->select(
                    $output,
                    'Select assets to install (TwitterBootstrap by default)',
                    $choices,
                    0,
                    false,
                    'La valeur "%s" est incorrecte',
                    true // active l'option multiselect
                );

                $selected = array_map(function($c) use ($choices) {
                    return $choices[$c];
                }, $selected);

                $this->assets = $selected;
            }
        }
    }

    protected function initializeDirectory($path, $clean=true) {
        if (false === strpos($path, $this->path)) {
            $path = $this->path . '/Resources/public/' . $path;
        }
        # create directory
        $filesystem = $this->getContainer()->get('filesystem');
        $filesystem->mkdir($path);
        # clean directory
        if (false != $clean) {
            $finder = new Finder();
            $finder->files()->in($path);
            foreach ($finder as $file) {
                $filesystem->remove($file);
            }
        }
        return $path;
    }

    protected function getTwitterBootstrapAssets($output)
    {
        # images
        $imagesPath = $this->initializeDirectory('images/bootstrap');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()->in($rootDir.'/../vendor/twitter/bootstrap/img');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, images files copied to @BootstrappBundle/Resources/public/img</info>');

        # js
        $jsPath = $this->initializeDirectory('js/bootstrap');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap/js')
            ->name('*.js');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');

        # less
        $lessPath = $this->initializeDirectory('less/bootstrap');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap/less')
            ->name('*.less');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $lessPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/less</info>');

        # parse sprites.less
        $glyphicons = file_get_contents($this->path . '/Resources/public/less/bootstrap/sprites.less');

        // replace comments //
        $glyphicons = preg_replace('/\s*\/\/.*/', '', $glyphicons);

        // replace [class^="icon-"], [class*=" icon-"] {}
        $glyphicons = preg_replace('/\[class.*=".*icon-"\][^{]*\{\s?((([^}"])*(".*")*)*)\s\}/', <<<EOF
.glyphicons(@x:14px, @y:14px) {
$1
  &:before {
    content: "";
  }

  &.icon-white {
    background-image: url("@{iconWhiteSpritePath}");
  }
}
EOF
            , $glyphicons, 1);
        $glyphicons = preg_replace('/background-position: 14px 14px;/', 'background-position: @x @y;', $glyphicons);
        $glyphicons = preg_replace('/.icon-white,\s*/', '', $glyphicons);

        // replace .icon-* {}
        $glyphicons = preg_replace('/(?<!&)\.icon((-\w*)+)(\s*\{)/', '.glyphicons$1()$3', $glyphicons);
        $glyphicons = preg_replace('/background-position\s?:\s?([-?\w]*)\s*([-?\w]*)\s*;/', '.glyphicons($1, $2);', $glyphicons);

        // Strip whitespaces
        $glyphicons = trim($glyphicons);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/glyphicons.less', <<<EOF
/*!
 * glyphicons.less v1.0.0
 *
 * Mixins implementation of the bootstrap sprites.less
 * See bootstrap/sprites.less for more informations
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$glyphicons
EOF
        );

        $output->writeln('<info>Success, glyphicons.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getTwitterCldrAssets($output)
    {
        $success = true;

        $cldrDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/twitter/twitter-cldr-js/lib/assets';
        $filesystem = $this->getContainer()->get('filesystem');

        # js
        $jsPath = $this->initializeDirectory('js/twitter-cldr');
        $finder = new Finder();
        $finder->files()->in($cldrDir.'/javascripts/twitter_cldr')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getBaseName());
        }

        return $success;
    }

    protected function getEntypoAssets($output)
    {
        $entypoDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/danielbruce/entypo/font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/entypo');
        $files = [
            'entypo.eot',
            'entypo.svg',
            'entypo.ttf',
            'entypo.woff',
        ];
        foreach($files as $file) {
            $filesystem->copy($entypoDir.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse entypo.css
        $entypo = file_get_contents($entypoDir.'entypo.css');

        // replace font path
        $entypo = str_replace("'entypo.", "'/bundles/bootstrapp/fonts/entypo/entypo.", $entypo);

        // replace .icon-*:before {}
        $entypo = preg_replace('/.icon((-\w*)+)(:before)/', '.entypo$1()', $entypo);
        $entypo = preg_replace('/content\s*:\s*(.*)\s*;/', '.entypo($1);', $entypo);

        // replace [class^="icon-"], [class*=" icon-"] {}
        $entypo = preg_replace('/\[class.*=".*icon-"\][^{]*\{\s?((([^}"])*(".*")*)*)\}/', <<<EOF
.entypo(@content:"") {
$1
  background-image: none;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}
EOF
            , $entypo);

        // remove .the-icons* {}
        $entypo = preg_replace('/\s.the-icons[\s\w]*\{[\s\w\-\:\;]*\}\s/', '', $entypo);

        // Strip whitespaces
        $entypo = trim($entypo);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/entypo.less', <<<EOF
/*!
 * entypo.less v1.0.0
 *
 * Mixins implementation of the entypo.css
 * See entypo.css for more informations
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$entypo
EOF
        );

        $output->writeln('<info>Success, entypo.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getFontAwesomeAssets($output)
    {
        $fontAwesomeDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/FortAwesome/Font-Awesome/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/fontawesome');
        $files = [
            'fontawesome-webfont.eot',
            'fontawesome-webfont.ttf',
            'fontawesome-webfont.woff',
            'FontAwesome.otf',
        ];
        foreach($files as $file) {
            $filesystem->copy($fontAwesomeDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse font-awesome.less
        $lessFile = file_get_contents($fontAwesomeDir.'less/font-awesome.less');

        // replace @import by content
        preg_match_all('/@import\s+"(.*)".*/', $lessFile, $matches, PREG_SET_ORDER);
        if (!isset($matches[1])) {
            return false;
        }
        foreach ($matches as $match) {
            $lessFile = str_replace($match[0], file_get_contents($fontAwesomeDir.'less/'.$match[1]), $lessFile);
        }

        // replace font path
        $lessFile = str_replace('"../font"', "'/bundles/bootstrapp/fonts/fontawesome'", $lessFile);

        // replace .icon-*:before {}
        do {
            $lessFile = preg_replace_callback('/.icon([-\w]*):before,?\s*([^{]*)\{([^\n]*)\}/', function($m){
                $replace = str_pad('.fontawesome' . $m[1] . "()", 38) . " { " . $m[3] . " }";
                if (!empty($m[2])) {
                    $replace .= "\n" . $m[2] . " { " . $m[3] . " }";
                }
                return $replace;
            }, $lessFile, -1, $count);
        } while ($count > 0);
        $lessFile = preg_replace('/^(.fontawesome.*[{])\s*content\s*:\s*([^;]*)\s*;?\s*([^}]*})$/m', '$1 .fontawesome($2); $3', $lessFile);

        // get [class^="icon-"], [class*=" icon-"] {}
        preg_match_all('/^\[class.*=".*icon-"\][^{:]*\{((?:\s.*\s)*)\}/m', $lessFile, $matches);
        $content = trim(implode('', $matches[1]), "\n\r");
        // get [class^="icon-"]:before, [class*=" icon-"]:before {}
        preg_match_all('/^\[class.*=".*icon-"\][^{]*:before\s*\{((?:\s.*\s)*)\}/m', $lessFile, $matches);
        $before = str_replace(' ', '  ', implode('', array_map('trim',$matches[1])));
        $lessFile = preg_replace('/^\[class.*=".*icon-"\][^{:]*\{((?:\s.*\s)*)\}/m', <<<EOF
.fontawesome(@content:"") {
$content

  &:before {
    $before
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}
EOF
            , $lessFile, 1);
        // remove [class^="icon-"], [class*=" icon-"] {}
        $lessFile = preg_replace('/^(\/.*\s)?\[class.*=".*icon-"\][^{]*\{((?:\s.*\s)*)\}\s{1,2}/m', '', $lessFile);

        // Strip whitespaces
        $lessFile = trim($lessFile);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/fontawesome.less', <<<EOF
/*!
 * fontawesome.less v3.2.1
 *
 * Mixins implementation of the Font-Awesome less file
 * See vendor/FortAwesome/Font-Awesome/less/font-awesome.less for more informations
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$lessFile
EOF
        );

        $output->writeln('<info>Success, entypo.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getJdewitAssets($output)
    {
        $success = true;

        $jdewitDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/jdewit/bootstrap-timepicker';
        $filesystem = $this->getContainer()->get('filesystem');

        # js
        if(is_file($jsFile = $jdewitDir.'/js/bootstrap-timepicker.js')) {
            $jsPath = $this->initializeDirectory('js', false);
            $filesystem->copy($jsFile, $jsPath . '/jdewit-timepicker.js');
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        if(is_file($lessFile = $jdewitDir.'/less/timepicker.less')) {
            $lessPath = $this->initializeDirectory('less', false);
            $filesystem->copy($lessFile, $lessPath . '/jdewit-timepicker.less');
            $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, less files not found!</error>');
            $success = false;
        }

        return $success;
    }

    protected function getEternicodeAssets($output)
    {
        $success = true;

        $eternicodeDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/eternicode/bootstrap-datepicker';
        $filesystem = $this->getContainer()->get('filesystem');

        # js
        if(is_file($jsFile = $eternicodeDir.'/js/bootstrap-datepicker.js')) {
            $jsPath = $this->initializeDirectory('js/eternicode');
            $finder = new Finder();
            $finder->files()->in($eternicodeDir.'/js')->name('*.js');
            foreach ($finder as $file) {
                $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
            }
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        if(is_file($lessFile = $eternicodeDir.'/less/datepicker.less')) {
            $lessPath = $this->initializeDirectory('less', false);
            $filesystem->copy($lessFile, $lessPath . '/eternicode-datepicker.less');
            $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, less files not found!</error>');
            $success = false;
        }

        return $success;
    }

    protected function getVitaletsAssets($output)
    {
        $success = true;

        $vitaletsDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/vitalets/bootstrap-datepicker';
        $filesystem = $this->getContainer()->get('filesystem');

        # js
        if(is_file($jsFile = $vitaletsDir.'/js/bootstrap-datepicker.js')) {
            $jsPath = $this->initializeDirectory('js/vitalets');
            $finder = new Finder();
            $finder->files()->in($vitaletsDir.'/js')->name('*.js');
            foreach ($finder as $file) {
                $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
            }
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        $lessFile = $vitaletsDir.'/less/datepicker.less';
        if(is_file($lessFile)) {
            # parse font-awesome.less
            $lessFile = file_get_contents($lessFile);
            $lessFile = preg_replace('/^\/\*.*(\s{2}\*.*)+\s*/', <<<EOF
$0
/*------------------------------*
 * Twitter Bootstrap less files *
 *------------------------------*/
@import "bootstrap/variables.less";
@import "bootstrap/mixins.less";


EOF
            , $lessFile, 1);
            $lessPath = $this->initializeDirectory('less', false);
            file_put_contents($lessPath . '/vitalets-datepicker.less', $lessFile);
            $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, less files not found!</error>');
            $success = false;
        }

        return $success;
    }

    protected function getMobiscrollAssets($output)
    {
        $success = true;

        $mobiscrollDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/acidb/mobiscroll';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/mobiscroll');
        $finder = new Finder();
        $finder->files()->in($mobiscrollDir.'/css')->name('*.css')->depth('== 0');
        foreach ($finder as $file) {
            $filesystem->copy($file, $cssPath . '/' . $file->getBaseName());
        }

        # js
        $jsPath = $this->initializeDirectory('js/mobiscroll');
        $finder = new Finder();
        $finder->files()->in($mobiscrollDir.'/js')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getJQueryUIAssets($output)
    {
        $success = true;

        $jqueryDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/jquery/jquery-ui';
        $filesystem = $this->getContainer()->get('filesystem');

        # css & images
        $finder = new Finder();
        $iteratorThemes = $finder->directories()->in($jqueryDir.'/themes')->depth('== 0')->getIterator();
        foreach ($iteratorThemes as $themeDirectory) {
            # images
            $imagesPath = $this->initializeDirectory('images/jquery-ui/' . $themeDirectory->getBasename());
            $finder = new Finder();
            $finder->files()->in($themeDirectory->getPathname() . '/images');
            foreach ($finder as $file) {
                $filesystem->copy($file, $imagesPath . '/' . $file->getRelativePathname());
            }
            # css
            $cssPath = $this->initializeDirectory('css/jquery-ui/' . $themeDirectory->getBasename());
            $finder = new Finder();
            $finder->files()->in($themeDirectory->getPathname())->name('*.css');
            foreach ($finder as $file) {
                $destination = $cssPath . '/' . $file->getRelativePathname();
                $filesystem->copy($file, $destination);
                if ('jquery.ui.theme.css' === $file->getBaseName()) {
                    // replace images path
                    $themeFile = file_get_contents($destination);
                    $imagesUrl = '/bundles/bootstrapp/images/jquery-ui/' . $themeDirectory->getBasename() . '/';
                    $themeFile = str_replace('images/', $imagesUrl, $themeFile);
                    file_put_contents($destination, $themeFile);
                }
            }
        }

        # js
        $jsPath = $this->initializeDirectory('js/jquery-ui');
        $finder = new Finder();
        $finder->files()->in($jqueryDir.'/ui')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getAddyosmaniAssets($output)
    {
        $success = true;

        $addyosmaniDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/addyosmani/jquery-ui-bootstrap';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/jquery-ui/addyosmani/');
        $finder = new Finder();
        $finder->files()->in($addyosmaniDir.'/css/custom-theme')->name('*.css');
        foreach ($finder as $file) {
            $destination = $cssPath . '/' . $file->getBaseName();
            $filesystem->copy($file, $destination);
            // replace images path
            $themeFile = file_get_contents($destination);
            $imagesUrl = '/bundles/bootstrapp/images/jquery-ui/addyosmani/';
            $themeFile = str_replace('images/', $imagesUrl, $themeFile);
            file_put_contents($destination, $themeFile);
        }

        # images
        $imagesPath = $this->initializeDirectory('images/jquery-ui/addyosmani');
        $finder = new Finder();
        $finder->files()->in($addyosmaniDir.'/css/custom-theme/images');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/' . $file->getBaseName());
        }

        return $success;
    }

    protected function getPickadateAssets($output)
    {
        $success = true;

        $pickadateDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/amsul/pickadate.js/lib';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/pickadate');
        $finder = new Finder();
        $finder->files()->in($pickadateDir.'/themes')->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $cssPath. '/' . $file->getBaseName());
        }

        # js
        $jsPath = $this->initializeDirectory('js/pickadate');
        $finder = new Finder();
        $finder->files()->in($pickadateDir)->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getRedactorAssets($output)
    {
        $success = true;

        $redactorDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/dybskiy/redactor-js/redactor';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/redactor');
        $finder = new Finder();
        $finder->files()->in($redactorDir)->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $cssPath . '/' . $file->getRelativePathname());
        }

        # js
        $jsPath = $this->initializeDirectory('js/redactor');
        $finder = new Finder();
        $finder->files()->in($redactorDir)->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getElFinderAssets($output)
    {
        $success = true;

        $elfinderDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/studio-42/elfinder';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/elfinder');
        $finder = new Finder();
        $finder->files()->in($elfinderDir.'/css')->name('*.css');
        foreach ($finder as $file) {
            $content = file_get_contents($file->getPathname());
            // replace images url
            $content = str_replace('../img', '/bundles/bootstrapp/images/elfinder', $content);
            file_put_contents($cssPath . '/' . $file->getRelativePathname(), $content);
        }

        # images
        $imagesPath = $this->initializeDirectory('images/elfinder');
        $finder = new Finder();
        $finder->files()->in($elfinderDir.'/img');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/' . $file->getRelativePathname());
        }

        # js
        $jsPath = $this->initializeDirectory('js/elfinder');
        $finder = new Finder();
        $finder->files()->in($elfinderDir.'/js')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        # php lib
        $libPath = $this->initializeDirectory($this->path . '/Resources/lib/elfinder');
        $finder = new Finder();
        $finder->files()->in($elfinderDir.'/php');
        foreach ($finder as $file) {
            $filesystem->copy($file, $libPath . '/' . $file->getRelativePathname());
        }

        # sounds
        $soundsPath = $this->initializeDirectory('sounds/elfinder');
        $finder = new Finder();
        $finder->files()->in($elfinderDir.'/sounds');
        foreach ($finder as $file) {
            $filesystem->copy($file, $soundsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getJQuerySortableAssets($output)
    {
        $success = true;

        $jQuerySortableDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/johnny/jquery-sortable/source';
        $filesystem = $this->getContainer()->get('filesystem');

        # js
        $jsPath = $this->initializeDirectory('js/jquery-sortable');
        $finder = new Finder();
        $finder->files()->in($jQuerySortableDir.'/js')->name('jquery-sortable*');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }
}