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
    private $path;

    protected function configure()
    {
        $this
            ->setName('bootstrapp:install')
            ->setDescription('Install bootstrapp assets into BootstrappBundle public folder')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->path = $this->getContainer()->get('kernel')->getBundle('BootstrappBundle')->getPath();

        $output->writeln('<comment>Installing Twitter Bootstrap assets...</comment>');
        if(true === $this->getTwitterBootstrapAssets($output)) {
            $output->writeln('<info>Success, Twitter Bootstrap assets installed!</info>');
        } else {
            $output->writeln('<error>Error : Twitter Bootstrap assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing Twitter CLDR assets...</comment>');
        if(true === $this->getTwitterCldrAssets($output)) {
            $output->writeln('<info>Success, Twitter CLDR assets installed!</info>');
        } else {
            $output->writeln('<error>Error : Twitter CLDR assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing Entypo assets...</comment>');
        if(true === $this->getEntypoAssets($output)) {
            $output->writeln('<info>Success, Entypo assets installed!</info>');
        } else {
            $output->writeln('<error>Error : Entypo assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing FontAwesome assets...</comment>');
        if(true === $this->getFontAwesomeAssets($output)) {
            $output->writeln('<info>Success, FontAwesome assets installed!</info>');
        } else {
            $output->writeln('<error>Error : FontAwesome assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing jdewit assets...</comment>');
        if(true === $this->getJdewitAssets($output)) {
            $output->writeln('<info>Success, jdewit assets installed!</info>');
        } else {
            $output->writeln('<error>Error : jdewit assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing eternicode assets...</comment>');
        if(true === $this->getEternicodeAssets($output)) {
            $output->writeln('<info>Success, eternicode assets installed!</info>');
        } else {
            $output->writeln('<error>Error : eternicode assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing vitalets assets...</comment>');
        if(true === $this->getVitaletsAssets($output)) {
            $output->writeln('<info>Success, vitalets assets installed!</info>');
        } else {
            $output->writeln('<error>Error : vitalets assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing mobiscroll assets...</comment>');
        if(true === $this->getMobiscrollAssets($output)) {
            $output->writeln('<info>Success, mobiscroll assets installed!</info>');
        } else {
            $output->writeln('<error>Error : mobiscroll assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing jquery-ui assets...</comment>');
        if(true === $this->getJQueryUIAssets($output)) {
            $output->writeln('<info>Success, jquery-ui assets installed!</info>');
        } else {
            $output->writeln('<error>Error : jquery-ui assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing addyosmani assets...</comment>');
        if(true === $this->getAddyosmaniAssets($output)) {
            $output->writeln('<info>Success, addyosmani assets installed!</info>');
        } else {
            $output->writeln('<error>Error : addyosmani assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing pickadate assets...</comment>');
        if(true === $this->getPickadateAssets($output)) {
            $output->writeln('<info>Success, pickadate assets installed!</info>');
        } else {
            $output->writeln('<error>Error : pickadate assets installation failed!</error>');
        }

        $output->writeln('<comment>Installing redactor assets...</comment>');
        if(true === $this->getRedactorAssets($output)) {
            $output->writeln('<info>Success, redactor assets installed!</info>');
        } else {
            $output->writeln('<error>Error : redactor assets installation failed!</error>');
        }
    }

    protected function createResourcesPublicCss() {
        if (!is_dir($this->path . '/Resources/public/css/')) {
            mkdir($this->path . '/Resources/public/css/', 0777, true);
        }
        return $this;
    }

    protected function createResourcesPublicFonts() {
        if (!is_dir($this->path . '/Resources/public/fonts/')) {
            mkdir($this->path . '/Resources/public/fonts/', 0777, true);
        }
        return $this;
    }

    protected function createResourcesPublicImages() {
        if (!is_dir($this->path . '/Resources/public/images/')) {
            mkdir($this->path . '/Resources/public/images/', 0777, true);
        }
        return $this;
    }

    protected function createResourcesPublicJs() {
        if (!is_dir($this->path . '/Resources/public/js/')) {
            mkdir($this->path . '/Resources/public/js/', 0777, true);
        }
        return $this;
    }

    protected function createResourcesPublicLess() {
        if (!is_dir($this->path . '/Resources/public/less/')) {
            mkdir($this->path . '/Resources/public/less/', 0777, true);
        }
        return $this;
    }

    protected function getTwitterBootstrapAssets($output)
    {
        # images
        $this->createResourcesPublicImages();
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()->in($rootDir.'/../vendor/twitter/bootstrap/img');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/images/bootstrap/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, images files copied to @BootstrappBundle/Resources/public/img</info>');

        # js
        $this->createResourcesPublicJs();
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap/js')
            ->name('*.js');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/bootstrap/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');

        # less
        $this->createResourcesPublicLess();
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap/less')
            ->name('*.less');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/less/bootstrap/' . $file->getBaseName());
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

        file_put_contents($this->path . '/Resources/public/less/icons/glyphicons.less', <<<EOF
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
        $this->createResourcesPublicJs();
        $finder = new Finder();
        $finder->files()->in($cldrDir.'/javascripts/twitter_cldr')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/twitter-cldr/' . $file->getBaseName());
        }

        return $success;
    }

    protected function getEntypoAssets($output)
    {
        $entypoDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/danielbruce/entypo/font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $this->createResourcesPublicFonts();
        $files = [
            'entypo.eot',
            'entypo.svg',
            'entypo.ttf',
            'entypo.woff',
        ];
        foreach($files as $file) {
            $filesystem->copy($entypoDir.$file, $this->path . '/Resources/public/fonts/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # css
        #$outputFile = $this->path . '/Resources/public/css/entypo.css';
        #$filesystem->copy($entypoDir.'entypo.css', $outputFile);
        #$output->writeln('<info>Success, css files written in @BootstrappBundle/Resources/public/css</info>');


        # parse entypo.css
        $entypo = file_get_contents($entypoDir.'entypo.css');

        // replace font path
        $entypo = str_replace("'entypo.", "'/bundles/bootstrapp/fonts/entypo.", $entypo);

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

        file_put_contents($this->path . '/Resources/public/less/icons/entypo.less', <<<EOF
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
        $this->createResourcesPublicFonts();
        $files = [
            'fontawesome-webfont.eot',
            'fontawesome-webfont.ttf',
            'fontawesome-webfont.woff',
            'FontAwesome.otf',
        ];
        foreach($files as $file) {
            $filesystem->copy($fontAwesomeDir.'font/'.$file, $this->path . '/Resources/public/fonts/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse font-awesome.less
        $lessFile = file_get_contents($fontAwesomeDir.'less/font-awesome.less');

        // replace font path
        $lessFile = str_replace('"../font"', "'/bundles/bootstrapp/fonts'", $lessFile);

        // replace .icon-*:before {}
        //$lessFile = preg_replace('/.icon((-\w*)+)(:before)/', '.fontawesome$1()', $lessFile);
        $lessFile = preg_replace('/.icon((-\w*)+)(:before)([^{]*\{[^\n]*\})/', '.fontawesome$1()$4', $lessFile);
        $lessFile = preg_replace('/content\s*:\s*(.*)\s*;/', '.fontawesome($1);', $lessFile);

        // get [class^="icon-"]:before, [class*=" icon-"]:before {}
        preg_match('/\s?\[class.*=".*icon-"\]:before[^{]*\{(\s?((([^}"])*(".*")*)*))\}\s?/', $lessFile, $matches);
        $before = isset($matches[1]) ? $matches[1] : null;
        $lessFile = preg_replace('/\s?\[class.*=".*icon-"\]:before[^{]*\{\s?((([^}"])*(".*")*)*)\}\s?/', '', $lessFile, 1);

        // replace [class^="icon-"], [class*=" icon-"] {}
        $lessFile = preg_replace('/\[class.*=".*icon-"\][^{]*\{\s?((([^}"])*(".*")*)*)\}/', <<<EOF
.fontawesome(@content:"") {
$1

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

        // Strip whitespaces
        $lessFile = trim($lessFile);

        file_put_contents($this->path . '/Resources/public/less/icons/fontawesome.less', <<<EOF
/*!
 * fontawesome.less v1.0.0
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
            $this->createResourcesPublicJs();
            $filesystem->copy($jsFile, $this->path . '/Resources/public/js/jdewit-timepicker.js');
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        if(is_file($lessFile = $jdewitDir.'/less/timepicker.less')) {
            $this->createResourcesPublicLess();
            $filesystem->copy($lessFile, $this->path . '/Resources/public/less/jdewit-timepicker.less');
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
            $this->createResourcesPublicJs();
            $filesystem->copy($jsFile, $this->path . '/Resources/public/js/eternicode-datepicker.js');
            # copy locales files
            $finder = new Finder();
            $finder->files()->in($eternicodeDir.'/js/locales')->name('*.js')->depth('== 0');
            foreach ($finder as $file) {
                $filesystem->copy($file, $this->path . '/Resources/public/js/eternicode-locales/' . $file->getBaseName());
            }
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        if(is_file($lessFile = $eternicodeDir.'/less/datepicker.less')) {
            $this->createResourcesPublicLess();
            $filesystem->copy($lessFile, $this->path . '/Resources/public/less/eternicode-datepicker.less');
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
            $this->createResourcesPublicJs();
            $filesystem->copy($jsFile, $this->path . '/Resources/public/js/vitalets-datepicker.js');
            # copy locales files
            $finder = new Finder();
            $finder->files()->in($vitaletsDir.'/js/locales')->name('*.js')->depth('== 0');
            foreach ($finder as $file) {
                $filesystem->copy($file, $this->path . '/Resources/public/js/vitalets-locales/' . $file->getBaseName());
            }
            $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');
        } else {
            $output->writeln('<error>Error, js files not found!</error>');
            $success = false;
        }

        # less
        if(is_file($lessFile = $vitaletsDir.'/less/datepicker.less')) {
            $this->createResourcesPublicLess();
            $filesystem->copy($lessFile, $this->path . '/Resources/public/less/vitalets-datepicker.less');
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
        $this->createResourcesPublicCss();
        $finder = new Finder();
        $finder->files()->in($mobiscrollDir.'/css')->name('*.css')->depth('== 0');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/css/mobiscroll/' . $file->getBaseName());
        }

        # js
        $this->createResourcesPublicJs();
        $finder = new Finder();
        $finder->files()->in($mobiscrollDir.'/js')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/mobiscroll/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getJQueryUIAssets($output)
    {
        $success = true;

        $jqueryDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/jquery/jquery-ui';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $this->createResourcesPublicCss();
        $finder = new Finder();
        $finder->files()->in($jqueryDir.'/themes')->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/css/jquery-ui/' . $file->getRelativePathname());
        }

        # images
        $this->createResourcesPublicImages();
        $finder = new Finder();
        $finder->files()->in($jqueryDir.'/themes/base/images');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/images/jquery-ui/base/' . $file->getBaseName());
        }

        # js
        $this->createResourcesPublicJs();
        $finder = new Finder();
        $finder->files()->in($jqueryDir.'/ui')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/jquery-ui/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getAddyosmaniAssets($output)
    {
        $success = true;

        $addyosmaniDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/addyosmani/jquery-ui-bootstrap';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $this->createResourcesPublicCss();
        $finder = new Finder();
        $finder->files()->in($addyosmaniDir.'/css/custom-theme')->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/css/jquery-ui/addyosmani/' . $file->getBaseName());
        }

        # images
        $this->createResourcesPublicImages();
        $finder = new Finder();
        $finder->files()->in($addyosmaniDir.'/css/custom-theme/images');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/images/jquery-ui/addyosmani/' . $file->getBaseName());
        }

        return $success;
    }

    protected function getPickadateAssets($output)
    {
        $success = true;

        $pickadateDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/amsul/pickadate';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $this->createResourcesPublicCss();
        $finder = new Finder();
        $finder->files()->in($pickadateDir)->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/css/pickadate/' . $file->getBaseName());
        }

        # js
        $this->createResourcesPublicImages();
        $finder = new Finder();
        $finder->files()->in($pickadateDir)->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/pickadate/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getRedactorAssets($output)
    {
        $success = true;

        $redactorDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/dybskiy/redactor-js/redactor';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $this->createResourcesPublicCss();
        $finder = new Finder();
        $finder->files()->in($redactorDir)->name('*.css');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/css/' . $file->getBaseName());
        }

        # js
        $this->createResourcesPublicJs();
        $finder = new Finder();
        $finder->files()->in($redactorDir)->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $this->path . '/Resources/public/js/' . $file->getBaseName());
        }

        return $success;
    }
}