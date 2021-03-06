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
        'TwitterBootstrap2',
        'TwitterCldr',
        'Entypo',
        'FontAwesome',
        'Brandico',
        'Fontelico',
        'Maki',
        'Meteocons',
        'Ionicons',
        'Elusive',
        'MfgLabs',
        'LigatureSymbols',
        'Jdewit',
        'Eternicode',
        'VitaletsDatepicker',
        'Mobiscroll',
        'JQueryUI',
        'Addyosmani',
        'Pickadate',
        'Redactor',
        'ElFinder',
        'JQuerySortable',
        'Select2',
        'CKEditor',
        'VitaletsXEditable'
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

        if(in_array('TwitterBootstrap2', $this->assets)) {
            $output->writeln('<comment>Installing Twitter Bootstrap v2.3.2 assets...</comment>');
            if(true === $this->getTwitterBootstrap2Assets($output)) {
                $output->writeln('<info>Success, Twitter Bootstrap v2.3.2 assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Twitter Bootstrap v2.3.2 assets installation failed!</error>');
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

        if(in_array('Brandico', $this->assets)) {
            $output->writeln('<comment>Installing Brandico assets...</comment>');
            if(true === $this->getBrandicoAssets($output)) {
                $output->writeln('<info>Success, Brandico assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Brandico assets installation failed!</error>');
            }
        }

        if(in_array('Fontelico', $this->assets)) {
            $output->writeln('<comment>Installing Fontelico assets...</comment>');
            if(true === $this->getFontelicoAssets($output)) {
                $output->writeln('<info>Success, Fontelico assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Fontelico assets installation failed!</error>');
            }
        }

        if(in_array('Maki', $this->assets)) {
            $output->writeln('<comment>Installing Maki assets...</comment>');
            if(true === $this->getMakiAssets($output)) {
                $output->writeln('<info>Success, Maki assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Maki assets installation failed!</error>');
            }
        }

        if(in_array('Meteocons', $this->assets)) {
            $output->writeln('<comment>Installing Meteocons assets...</comment>');
            if(true === $this->getMeteoconsAssets($output)) {
                $output->writeln('<info>Success, Meteocons assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Meteocons assets installation failed!</error>');
            }
        }

        if(in_array('Ionicons', $this->assets)) {
            $output->writeln('<comment>Installing Ionicons assets...</comment>');
            if(true === $this->getIoniconsAssets($output)) {
                $output->writeln('<info>Success, Ionicons assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Ionicons assets installation failed!</error>');
            }
        }

        if(in_array('Elusive', $this->assets)) {
            $output->writeln('<comment>Installing Elusive assets...</comment>');
            if(true === $this->getElusiveAssets($output)) {
                $output->writeln('<info>Success, Elusive assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Elusive assets installation failed!</error>');
            }
        }

        if(in_array('MfgLabs', $this->assets)) {
            $output->writeln('<comment>Installing MfgLabs assets...</comment>');
            if(true === $this->getMfgLabsAssets($output)) {
                $output->writeln('<info>Success, MfgLabs assets installed!</info>');
            } else {
                $output->writeln('<error>Error : MfgLabs assets installation failed!</error>');
            }
        }

        if(in_array('LigatureSymbols', $this->assets)) {
            $output->writeln('<comment>Installing LigatureSymbols assets...</comment>');
            if(true === $this->getLigatureSymbolsAssets($output)) {
                $output->writeln('<info>Success, LigatureSymbols assets installed!</info>');
            } else {
                $output->writeln('<error>Error : LigatureSymbols assets installation failed!</error>');
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

        if(in_array('VitaletsDatepicker', $this->assets)) {
            $output->writeln('<comment>Installing vitalets datepicker assets...</comment>');
            if(true === $this->getVitaletsDatepickerAssets($output)) {
                $output->writeln('<info>Success, vitalets datepicker assets installed!</info>');
            } else {
                $output->writeln('<error>Error : vitalets datepicker assets installation failed!</error>');
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

        if(in_array('Select2', $this->assets)) {
            $output->writeln('<comment>Installing Select2 assets...</comment>');
            if(true === $this->getSelect2Assets($output)) {
                $output->writeln('<info>Success, Select2 assets installed!</info>');
            } else {
                $output->writeln('<error>Error : Select2 assets installation failed!</error>');
            }
        }

        if(in_array('CKEditor', $this->assets)) {
            $output->writeln('<comment>Installing CKEditor assets...</comment>');
            if(true === $this->getCKEditorAssets($output)) {
                $output->writeln('<info>Success, CKEditor assets installed!</info>');
            } else {
                $output->writeln('<error>Error : CKEditor assets installation failed!</error>');
            }
        }

        if(in_array('VitaletsXEditable', $this->assets)) {
            $output->writeln('<comment>Installing X-editable assets...</comment>');
            if(true === $this->getVitaletsXEditableAssets($output)) {
                $output->writeln('<info>Success, X-editable assets installed!</info>');
            } else {
                $output->writeln('<error>Error : X-editable assets installation failed!</error>');
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
        $filesystem = $this->getContainer()->get('filesystem');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $bootstrapDir = $rootDir.'/../vendor/twitter/bootstrap';

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/glyphicons');
        $finder = new Finder();
        $finder->files()->in($bootstrapDir.'/fonts');
        foreach ($finder as $file) {
            $filesystem->copy($file, $fontsPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, fonts files copied to @BootstrappBundle/Resources/public/fonts</info>');

        # js
        $jsPath = $this->initializeDirectory('js/bootstrap3');
        $finder = new Finder();
        $finder->files()->name('*.js')->in([$bootstrapDir.'/js', $bootstrapDir.'/dist/js'])->depth('== 0');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');

        # less
        $lessPath = $this->initializeDirectory('less/bootstrap3');
        $finder = new Finder();
        $finder->files()->name('*.less')->in($bootstrapDir.'/less');
        foreach ($finder as $file) {
            $filesystem->copy($file, $lessPath . '/' . $file->getRelativePathname());
        }
        $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/less</info>');

        # parse glyphicons.less
        $glyphicons = file_get_contents($this->path . '/Resources/public/less/bootstrap3/glyphicons.less');

        // replace .glyphicon {}
        $glyphicons = preg_replace('/\.glyphicon\s*\{\s?((([^}"])*(".*")*)*)\s\}/', <<<EOF
.glyphicon(@content:"") {
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
            , $glyphicons, 1);

        // replace .icon-* {}
        $glyphicons = preg_replace('/\.glyphicon((-\w*)+)(\s*\{)/', '.glyphicons$1()$3', $glyphicons);
        $glyphicons = preg_replace('/&:before\s*\{\s*content:\s*"([^"]*)";\s*\}/', '.glyphicon("$1");', $glyphicons);

        // Strip whitespaces
        $glyphicons = trim($glyphicons);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/glyphicons.less', <<<EOF
/*!
 * glyphicons.less v3.0.0
 *
 * Mixins implementation of the bootstrap glyphicons.less
 * See bootstrap/glyphicons.less for more informations
 *
 * Copyright (c) 2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/bootstrap3-variables.less";

$glyphicons
EOF
        );

        $output->writeln('<info>Success, glyphicons.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getTwitterBootstrap2Assets($output)
    {
        # images
        $imagesPath = $this->initializeDirectory('images/bootstrap2');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()->in($rootDir.'/../vendor/twitter/bootstrap2/img');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, images files copied to @BootstrappBundle/Resources/public/img</info>');

        # js
        $jsPath = $this->initializeDirectory('js/bootstrap2');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap2/js')
            ->name('*.js');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, js files written in @BootstrappBundle/Resources/public/js</info>');

        # less
        $lessPath = $this->initializeDirectory('less/bootstrap2');
        $rootDir = $this->getContainer()->get('kernel')->getRootDir();
        $finder = new Finder();
        $finder->depth('== 0');
        $finder->files()
            ->in($rootDir.'/../vendor/twitter/bootstrap2/less')
            ->name('*.less');
        $filesystem = $this->getContainer()->get('filesystem');
        foreach ($finder as $file) {
            $filesystem->copy($file, $lessPath . '/' . $file->getBaseName());
        }
        $output->writeln('<info>Success, less files written in @BootstrappBundle/Resources/public/less</info>');

        # parse sprites.less
        $glyphicons = file_get_contents($this->path . '/Resources/public/less/bootstrap2/sprites.less');

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
        file_put_contents($lessPath . '/glyphicons-sprite.less', <<<EOF
/*!
 * glyphicons.less v2.3.2
 *
 * Mixins implementation of the bootstrap sprites.less
 * See bootstrap/sprites.less for more informations
 *
 * Copyright (c) 2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/bootstrap2-variables.less";

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
        $entypoDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/danielbruce/entypo';
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
            $filesystem->copy($entypoDir.'/font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse entypo.css
        $entypo = file_get_contents($entypoDir.'/font/entypo.css');

        // replace font path
        $entypo = str_replace("'entypo.", "'/bundles/bootstrapp/fonts/entypo/entypo.", $entypo);

        // remove .icon-*:before {}
        $entypo = preg_replace('/.icon(-\w*)+:before.*/', '', $entypo);
        $entypo = trim($entypo);
        $entypo .= "\n";

        // get .icon-*:before rules
        $glyphs = [];
        $finder = new Finder();
        $finder->files()->in($entypoDir.'/src/original')->name('*.svg');
        foreach ($finder as $file) {
            $content = file_get_contents($file->getPathname());
            preg_match_all('/glyph-name="([^"]+)" unicode="&#x([^"]+);"/', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $name = trim($match[1]);
                $code = trim($match[2]);
                // replace special chars
                $name = str_replace(['+'], ['-plus'], $name);
                // name misspelling
                switch ($name) {
                    case 'c-radio':
                        $name = 'c-rdio';
                        break;
                }
                $glyphs[$name] = trim($code);
            }
        }
        ksort($glyphs);
        foreach ($glyphs as $name => $code) {
            $entypo .= "\n" . str_pad('.entypo-'.$name.'()', 30) . '{ ' . str_pad('.entypo("\\' . $code . '");', 18).' }';
        }

        // replace [class^="icon-"], [class*=" icon-"] {}
        $entypo = preg_replace('/\[class.*=".*icon-"\][^{]*\{\s?((([^}"])*(".*")*)*)\}/', <<<EOF
.entypo(@content:"") {
$1
  background-image: none !important;

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
 * Copyright (c) 2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$entypo

// Alias
// --------------------------
.entypo-flash() {
    .entypo-bolt();
}
.entypo-beamed-note() {
    .entypo-beamed-notes();
}
.entypo-show() {
	.entypo-text-doc();
}
.entypo-create() {
	.entypo-plus();
}
.entypo-update() {
	.entypo-pencil();
}
.entypo-delete() {
    .entypo-trash();
}
.entypo-restore() {
    .entypo-reply();
}
.entypo-cancel() {
    .entypo-cross();
}
.entypo-save() {
    .entypo-check();
}
.entypo-back() {
    .entypo-chevron-left();
}
/*
.entypo-chevron-up() {
    .entypo-chevron-small-up();
}
.entypo-chevron-right() {
    .entypo-chevron-small-right();
}
.entypo-chevron-left() {
    .entypo-chevron-small-left();
}
.entypo-chevron-down() {
    .entypo-chevron-small-down();
}
*/
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
            $filesystem->copy($fontAwesomeDir.'fonts/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse font-awesome.less
        $lessFile = file_get_contents($fontAwesomeDir.'less/font-awesome.less');

        // replace @import by content
        preg_match_all('/@import\s+"(.*)".*/', $lessFile, $matches, PREG_SET_ORDER);
        if (!isset($matches[1])) {
            $output->writeln('<error>Error, @import expected in font-awesome.less! Files structure seems to have changed.</error>');
            return false;
        }
        foreach ($matches as $match) {
            $file = $fontAwesomeDir.'less/'.$match[1];
            if (false === strpos($file, '.less')) {
                $file .= '.less';
            }
            if (!is_file($file)) {
                $output->writeln(sprintf('<error>Error, unable to import less file %s!</error>', $file));
                return false;
            }
            $lessFile = str_replace($match[0], file_get_contents($file), $lessFile);
        }

        // replace font path
        $lessFile = str_replace('"../fonts"', "'/bundles/bootstrapp/fonts/fontawesome'", $lessFile);

        // replace font class prefix (icon instead of fa)
        $lessFile = preg_replace('/(@fa-css-prefix:\s*)fa;/', '$1icon;', $lessFile);

        // replace .@{fa-css-prefix}-*:before {}
        do {
            $lessFile = preg_replace_callback('/.@\{fa-css-prefix\}([-\w]*):before,?\s*(.*)(?=\s+\{)\s+\{([^\n]*)\}/', function($m){
                $replace = str_pad('.fontawesome' . $m[1] . "()", 38) . " { " . trim($m[3]) . " }";
                if (!empty($m[2])) {
                    $replace .= "\n" . str_pad($m[2], 38) . " { " . trim($m[3]) . " }";
                }
                return $replace;
            }, $lessFile, -1, $count);
        } while ($count > 0);
        $lessFile = preg_replace('/^(.fontawesome.*[{])\s*content\s*:\s*([^;]*)\s*;?\s*([^}]*})$/m', '$1 .fontawesome($2); $3', $lessFile);

        // get .@{fa-css-prefix} {}
        preg_match_all('/^\.@\{fa-css-prefix\}\s*\{((?:\s.*\s)*)\}/m', $lessFile, $matches);
        $content = trim(implode('', $matches[1]), "\n\r");
        $lessFile = preg_replace('/^\.@{fa-css-prefix}\s*\{((?:\s.*\s)*)\}/m', <<<EOF
.fontawesome(@content:"") {
$content

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}
EOF
            , $lessFile, 1);
        // remove .@{fa-css-prefix} {}
        $lessFile = preg_replace('/^(\/.*\s)?\.@{fa-css-prefix}\s*\{((?:\s.*\s)*)\}\s{1,2}/m', '', $lessFile);

        // Strip whitespaces
        $lessFile = trim($lessFile);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/fontawesome.less', <<<EOF
/*!
 * fontawesome.less v4.0.3
 *
 * Mixins implementation of the Font-Awesome less file
 * See vendor/FortAwesome/Font-Awesome/less/font-awesome.less for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$lessFile

// Alias
// --------------------------
.fontawesome-settings() {
    .fontawesome-cog();
}
.fontawesome-show() {
	.fontawesome-eye();
}
.fontawesome-create() {
	.fontawesome-plus();
}
.fontawesome-update() {
	.fontawesome-pencil();
}
.fontawesome-delete() {
    .fontawesome-trash-o();
}
.fontawesome-restore() {
    .fontawesome-reply();
}
.fontawesome-cancel() {
    .fontawesome-times();
}
.fontawesome-back() {
    .fontawesome-chevron-left();
}
.fontawesome-help() {
    .fontawesome-question();
}
EOF
        );

        $output->writeln('<info>Success, fontawesome.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getBrandicoAssets($output)
    {
        $brandicoDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/fontello/brandico.font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/brandico');
        $files = [
            'brandico.eot',
            'brandico.svg',
            'brandico.ttf',
            'brandico.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($brandicoDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse demo.html
        $content = '';
        $demoFile = file_get_contents($brandicoDir.'font/demo.html');

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $demoFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('brandico.', '/bundles/bootstrapp/fonts/brandico/brandico.', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\[class.*=".*icon-"\][^{]*\{\s?([^}]*)\s\}/', $demoFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.brandico(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        // get .icon-*:before rules
        preg_match_all('/.icon((?:-\w*)+):before\s*\{\s*content:\s*([^;]*)[^}]*\}/', $demoFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $content .= "\n" . str_pad('.brandico'.$match[1].'()', 30) . '{ .brandico(' . trim($match[2]). '); }';
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/brandico.less', <<<EOF
/*!
 * brandico.less v1.0.0
 *
 * Mixins implementation of the opensource iconic font from Fontello project
 * See vendor/fontello/brandico.font for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content
EOF
        );

        $output->writeln('<info>Success, brandico.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getFontelicoAssets($output)
    {
        $fontelicoDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/fontello/fontelico.font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/fontelico');
        $files = [
            'fontelico.eot',
            'fontelico.svg',
            'fontelico.ttf',
            'fontelico.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($fontelicoDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse demo.html
        $content = '';
        $demoFile = file_get_contents($fontelicoDir.'font/demo.html');

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $demoFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('fontelico.', '/bundles/bootstrapp/fonts/fontelico/fontelico.', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\[class.*=".*icon-"\][^{]*\{\s?([^}]*)\s\}/', $demoFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.fontelico(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        // get .icon-*:before rules
        preg_match_all('/.icon((?:-\w*)+):before\s*\{\s*content:\s*([^;]*)[^}]*\}/', $demoFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $content .= "\n" . str_pad('.fontelico'.$match[1].'()', 30) . '{ .fontelico(' . trim($match[2]). '); }';
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/fontelico.less', <<<EOF
/*!
 * fontelico.less v1.0.0
 *
 * Mixins implementation of the opensource iconic font from Fontello project
 * See vendor/fontello/fontelico.font for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content
EOF
        );

        $output->writeln('<info>Success, fontelico.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getMakiAssets($output)
    {
        $makiDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/fontello/maki.font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/maki');
        $files = [
            'maki.eot',
            'maki.svg',
            'maki.ttf',
            'maki.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($makiDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse demo.html
        $content = '';
        $demoFile = file_get_contents($makiDir.'font/demo.html');

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $demoFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('maki.', '/bundles/bootstrapp/fonts/maki/maki.', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\[class.*=".*icon-"\][^{]*\{\s?([^}]*)\s\}/', $demoFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.maki(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        // get .icon-*:before rules
        preg_match_all('/.icon((?:-\w*)+):before\s*\{\s*content:\s*([^;]*)[^}]*\}/', $demoFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $content .= "\n" . str_pad('.maki'.$match[1].'()', 30) . '{ .maki(' . trim($match[2]). '); }';
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/maki.less', <<<EOF
/*!
 * maki.less v1.0.0
 *
 * Mixins implementation of the POI Icon Set by MapBox
 * See vendor/fontello/maki.font for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content
EOF
        );

        $output->writeln('<info>Success, maki.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getMeteoconsAssets($output)
    {
        $meteoconsDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/fontello/meteocons.font/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/meteocons');
        $files = [
            'meteocons.eot',
            'meteocons.svg',
            'meteocons.ttf',
            'meteocons.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($meteoconsDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse demo.html
        $content = '';
        $demoFile = file_get_contents($meteoconsDir.'font/demo.html');

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $demoFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('meteocons.', '/bundles/bootstrapp/fonts/meteocons/meteocons.', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\[class.*=".*icon-"\][^{]*\{\s?([^}]*)\s\}/', $demoFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.meteocons(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        // get .icon-*:before rules
        preg_match_all('/.icon((?:-\w*)+):before\s*\{\s*content:\s*([^;]*)[^}]*\}/', $demoFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $content .= "\n" . str_pad('.meteocons'.$match[1].'()', 30) . '{ .meteocons(' . trim($match[2]). '); }';
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/meteocons.less', <<<EOF
/*!
 * meteocons.less v1.0.0
 *
 * Mixins implementation of the Meteocons set by Alessio Atzeni
 * See vendor/fontello/meteocons.font for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content
EOF
        );

        $output->writeln('<info>Success, meteocons.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getIoniconsAssets($output)
    {
        $ioniconsDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/driftyco/ionicons/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/ionicons');
        $files = [
            'ionicons.eot',
            'ionicons.svg',
            'ionicons.ttf',
            'ionicons.woff',
        ];
        foreach($files as $file) {
            $filesystem->copy($ioniconsDir.'fonts/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse ionicons.css
        $ionicons = file_get_contents($ioniconsDir.'css/ionicons.css');

        // replace font path
        $ionicons = str_replace("../fonts/ionicons.", "/bundles/bootstrapp/fonts/ionicons/ionicons.", $ionicons);

        // replace .ion-*:before {}
        do {
            $ionicons = preg_replace_callback('/\.ion([-\w]*):before,?\s*([^\s\{]*)\s*\{\s*content:\s*([^;]*)[^}]*\}\s*/', function($m){
                $replace = str_pad('.ionicons' . $m[1] . "()", 45) . " { .ionicons(" . trim($m[3]) . "); }";
                if (!empty($m[2])) {
                    $replace .= "\n" . str_pad($m[2], 45) . " { content: " . trim($m[3]) . "; }";
                }
                $replace .= "\n";
                return $replace;
            }, $ionicons, -1, $count);
        } while ($count > 0);

        // remove @keyframe {}
        $ionicons = preg_replace('/\s*\d+\%[^}]*\}\s*/', '', $ionicons);
        $ionicons = preg_replace('/@(.*-)?keyframes[^}]*\}\s*/', '', $ionicons);

        // replace .ion-* {}
        $ionicons = preg_replace('/(?:\.ion(?:-\w*)*[^}]*)+\{\s?([^}]*)\}\s*/', <<<EOF
.ionicons(@content:"") {
$1

  /* bootstrapp fix */
  background: none !important;
  line-height: 14px;
  font-size: 20px;
  font-weight: bold;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}


EOF
            , $ionicons, 1);

        // remove .ion-* {}
        $ionicons = preg_replace('/(?:.ion(?:-\w*)+,?\s*)+\{(?:[^}]*)\}\s*/', '', $ionicons);

        // Strip whitespaces
        $ionicons = trim($ionicons);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/ionicons.less', <<<EOF
/*!
 * ionicons.less v1.0.0
 *
 * Mixins implementation of the ionicons.css
 * See ionicons.css for more informations
 *
 * Copyright (c) 2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$ionicons

// Alias
// --------------------------
.ionicons-user() {
    .ionicons-ios7-person-outline();
}
.ionicons-settings() {
    .ionicons-ios7-gear-outline();
}
.ionicons-list() {
    .ionicons-ios7-drag();
}
.ionicons-show() {
	.ionicons-ios7-eye-outline();
}
.ionicons-create() {
	.ionicons-ios7-plus-outline();
}
.ionicons-update() {
	.ionicons-ios7-compose-outline();
}
.ionicons-delete() {
    .ionicons-ios7-trash-outline();
}
.ionicons-restore() {
    .ionicons-ios7-undo-outline();
}
.ionicons-cancel() {
    .ionicons-ios7-close-outline();
}
.ionicons-save() {
    .ionicons-ios7-checkmark-outline();
}
.ionicons-back() {
    .ionicons-ios7-arrow-back();
}
.ionicons-trash() {
    .ionicons-ios7-trash-outline();
}
.ionicons-help() {
    .ionicons-ios7-help-outline();
}
.ionicons-chevron-up() {
    .ionicons-ios7-arrow-up();
}
.ionicons-chevron-right() {
    .ionicons-ios7-arrow-right();
}
.ionicons-chevron-left() {
    .ionicons-ios7-arrow-left();
}
.ionicons-chevron-down() {
    .ionicons-ios7-arrow-down();
}
EOF
        );

        $output->writeln('<info>Success, ionicons.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getElusiveAssets($output)
    {
        $elusiveDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/aristath/elusive-iconfont/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/elusive');
        $files = [
            'Elusive-Icons.eot',
            'Elusive-Icons.svg',
            'Elusive-Icons.ttf',
            'Elusive-Icons.woff',
        ];
        foreach($files as $file) {
            $filesystem->copy($elusiveDir.'fonts/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse elusive-webfont.less
        $elusive = file_get_contents($elusiveDir.'less/elusive-webfont.less');

        // replace font path
        $elusive = str_replace("../fonts/", "/bundles/bootstrapp/fonts/elusive/", $elusive);

        // replace .el-icon-*:before {}
        do {
            $elusive = preg_replace_callback('/\.el-icon([-\w]*):before,?\s*([^\s\{]*)\s*\{\s*content:\s*([^;]*)[^}]*\}\s*/', function($m){
                $replace = str_pad('.elusive' . $m[1] . "()", 45) . " { .elusive(" . trim($m[3]) . "); }";
                if (!empty($m[2])) {
                    $replace .= "\n" . str_pad($m[2], 45) . " { content: " . trim($m[3]) . "; }";
                }
                $replace .= "\n";
                return $replace;
            }, $elusive, -1, $count);
        } while ($count > 0);

        // replace [class*="el-icon-"] {}
        $elusive = preg_replace('/\[class.*=".*icon-"\][^{]*\{\s?([^}]*)\s\}\s*/', <<<EOF
.elusive(@content:"") {
$1

    /* bootstrapp fix */
    background: none !important;

    &:before {
        content: @content;
    }

    &.icon-white {
        color: @white;
    }
}


EOF
            , $elusive, 1);

        // Strip whitespaces
        $elusive = trim($elusive);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/elusive.less', <<<EOF
/*!
 * elusive.less v1.0.0
 *
 * Mixins implementation of the Elusive Open-Source Iconfont
 * See elusive.css for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$elusive

// Alias
// --------------------------
.elusive-settings() {
    .elusive-cog();
}
.elusive-show() {
	.elusive-eye-open();
}
.elusive-create() {
	.elusive-plus();
}
.elusive-update() {
	.elusive-pencil();
}
.elusive-delete() {
    .elusive-trash-alt();
}
.elusive-restore() {
    .elusive-share-alt();
    .skew(0,180deg);
}
.elusive-cancel() {
    .elusive-remove-circle();
}
.elusive-save() {
    .elusive-ok-circle();
}
.elusive-back() {
    .elusive-chevron-left();
}
.elusive-help() {
    .elusive-question();
}
EOF
        );

        $output->writeln('<info>Success, elusive.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getMfgLabsAssets($output)
    {
        $mfglabsDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/MfgLabs/mfglabs-iconset/css/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/mfglabs');
        $files = [
            'mfglabsiconset-webfont.eot',
            'mfglabsiconset-webfont.svg',
            'mfglabsiconset-webfont.ttf',
            'mfglabsiconset-webfont.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($mfglabsDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse mfglabs_iconset.css
        $content = '';
        $cssFile = file_get_contents($mfglabsDir.'mfglabs_iconset.css');

        // get file header comment and licence
        preg_match_all('#/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/#', $cssFile, $matches);
        if (!empty($matches)) {
            $content .= $matches[0][0];
        }

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $cssFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('font/', '/bundles/bootstrapp/fonts/mfglabs/', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\.icon\s*\{\s?([^}]*)\s\}/', $cssFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.mfglabs(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  background: none !important;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        // get .icon-*:before rules
        preg_match_all('/.icon((?:-\w*)+):before\s*\{\s*content:\s*([^;]*)[^}]*\}/', $cssFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $match[1] = str_replace('_', '-', $match[1]);
            $content .= "\n" . str_pad('.mfglabs'.$match[1].'()', 30) . '{ .mfglabs(' . trim($match[2]). '); }';
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/mfglabs.less', <<<EOF
/*!
 * mfglabs.less v1.0.0
 *
 * Mixins implementation of the MFG Labs iconset
 * See https://github.com/MfgLabs/mfglabs-iconset for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content

// Alias
// --------------------------
.mfglabs-show() {
	.mfglabs-eye();
}
.mfglabs-create() {
	.mfglabs-plus();
}
.mfglabs-update() {
	.mfglabs-pen();
}
.mfglabs-delete() {
    .mfglabs-trash-can();
}
.mfglabs-restore() {
    .mfglabs-reply();
}
.mfglabs-cancel() {
    .mfglabs-cross-mark();
}
.mfglabs-save() {
    .mfglabs-check();
}
.mfglabs-back() {
    .mfglabs-chevron-left();
}
.mfglabs-trash() {
    .mfglabs-trash-can();
}
.mfglabs-help() {
    .mfglabs-white-question();
}
EOF
        );

        $output->writeln('<info>Success, mfglabs.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

        return true;
    }

    protected function getLigatureSymbolsAssets($output)
    {
        $ligatureDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/kudakurage/LigatureSymbols/site/';
        $filesystem = $this->getContainer()->get('filesystem');

        # fonts
        $fontsPath = $this->initializeDirectory('fonts/ligaturesymbols');
        $files = [
            'LigatureSymbols-2.11.eot',
            'LigatureSymbols-2.11.svg',
            'LigatureSymbols-2.11.ttf',
            'LigatureSymbols-2.11.woff'
        ];
        foreach($files as $file) {
            $filesystem->copy($ligatureDir.'font/'.$file, $fontsPath . '/' . basename($file));
        }
        $output->writeln('<info>Success, fonts files written in @BootstrappBundle/Resources/public/fonts</info>');

        # parse ligature.css
        $content = '';
        $cssFile = file_get_contents($ligatureDir.'style/ligature.css');

        // get @font-face
        preg_match_all('/@font-face\s*\{[^}]*\}/', $cssFile, $matches);
        if (!empty($matches)) {
            $content .= "\n" . str_replace('../font/', '/bundles/bootstrapp/fonts/ligaturesymbols/', $matches[0][0]);
        }

        // get mixin css
        preg_match_all('/\.lsf-icon:before\s*\{\s?([^}]*)\s\}/', $cssFile, $matches, PREG_SET_ORDER);
        if (!empty($matches)) {
            $content .= <<<EOF


.ligaturesymbols(@content:"") {
{$matches[0][1]}

  /* bootstrapp fix */
  display: inline-block;
  background: none !important;
  font-style: normal;
  font-size: 16px;
  vertical-align: baseline;

  &:before {
    content: @content;
  }

  &.icon-white {
    color: @white;
  }
}

EOF;
        }

        # parse index.html
        $indexFile = file_get_contents($ligatureDir.'index.html');

        // get ligatures
        preg_match_all('/<td\s*class="lsf symbol">([^<]*)<\/td>\s*<td\s*class="ligature">([^<]*)<\/td>\s*<td\s*class="unicode">([^<]*)<\/td>/', $indexFile, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $symbol = $match[1];
            $tags = explode(', ', $match[2]);
            $unicode = $match[3];
            foreach($tags as $tag) {
                $content .= "\n" . str_pad('.ligaturesymbols-'.$tag.'()', 40) . '{ .ligaturesymbols("' . trim($unicode). '"); }';
            }
        }

        // Strip whitespaces
        $content = trim($content);

        $lessPath = $this->initializeDirectory('less/icons', false);
        file_put_contents($lessPath . '/ligaturesymbols.less', <<<EOF
/*!
 * ligaturesymbols.less v1.0.0
 *
 * Mixins implementation of the LigatureSymbols web font by Kazuyuki Motoyama
 * See https://github.com/kudakurage/LigatureSymbols for more informations
 *
 * Copyright (c) 2013, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


@import "../bootstrapp/variables.less";

$content

// Alias
// --------------------------
.ligaturesymbols-settings() {
    .ligaturesymbols-setting();
}
.ligaturesymbols-show() {
	.ligaturesymbols-eye();
}
.ligaturesymbols-create() {
	.ligaturesymbols-plus();
}
.ligaturesymbols-update() {
	.ligaturesymbols-edit();
}
.ligaturesymbols-restore() {
    .ligaturesymbols-undo();
}
.ligaturesymbols-cancel() {
    .ligaturesymbols-remove();
}
.ligaturesymbols-save() {
    .ligaturesymbols-check();
}
.ligaturesymbols-back() {
    .ligaturesymbols-left();
}
.ligaturesymbols-chevron-up() {
    .ligaturesymbols-up();
}
.ligaturesymbols-chevron-right() {
    .ligaturesymbols-right();
}
.ligaturesymbols-chevron-left() {
    .ligaturesymbols-left();
}
.ligaturesymbols-chevron-down() {
    .ligaturesymbols-down();
}
EOF
        );

        $output->writeln('<info>Success, ligaturesymbols.less file written in @BootstrappBundle/Resources/public/less/icons</info>');

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

    protected function getVitaletsDatepickerAssets($output)
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
@import "bootstrapp/bootstrap2-variables.less";
@import "bootstrap2/mixins.less";


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

    protected function getSelect2Assets($output)
    {
        $success = true;

        $vendorDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/ivaynberg/select2';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/select2');
        $finder = new Finder();
        $finder->files()->in($vendorDir)->name('*.css');
        foreach ($finder as $file) {
            $content = file_get_contents($file->getPathname());
            // replace images url
            $content = str_replace("url('", "url('/bundles/bootstrapp/images/select2/", $content);
            file_put_contents($cssPath . '/' . $file->getRelativePathname(), $content);
        }

        # images
        $imagesPath = $this->initializeDirectory('images/select2');
        $finder = new Finder();
        $finder->files()->in($vendorDir)->name('*.gif')->name('*.jpg')->name('*.png');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/' . $file->getRelativePathname());
        }

        # js
        $jsPath = $this->initializeDirectory('js/select2');
        $finder = new Finder();
        $finder->files()->in($vendorDir)->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getCKEditorAssets($output)
    {
        $success = true;

        $vendorDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/ckeditor/ckeditor-releases';
        $filesystem = $this->getContainer()->get('filesystem');

        # css
        $cssPath = $this->initializeDirectory('css/ckeditor');
        $finder = new Finder();
        $finder->files()->in($vendorDir.'/skins')->name('*.css');
        foreach ($finder as $file) {
            $dirname = $file->getRelativePath();
            $filename = $cssPath . '/skins/' . $file->getRelativePathname();
            $filesystem->mkdir(dirname($filename));
            $content = file_get_contents($file->getPathname());
            // replace images url
            $content = str_replace('url(', 'url(/bundles/bootstrapp/images/ckeditor/skins/'.$dirname.'/', $content);
            file_put_contents($filename, $content);
        }

        # images
        $imagesPath = $this->initializeDirectory('images/ckeditor');
        $finder = new Finder();
        $finder->files()->in($vendorDir.'/skins')->name('*.gif')->name('*.jpg')->name('*.png');
        foreach ($finder as $file) {
            $filesystem->copy($file, $imagesPath . '/skins/' . $file->getRelativePathname());
        }

        # js
        $jsPath = $this->initializeDirectory('js/ckeditor');
        $filesystem->copy($vendorDir.'/ckeditor.js', $jsPath . '/ckeditor.js');
        $filesystem->copy($vendorDir.'/config.js', $jsPath . '/config.js');
        $filesystem->copy($vendorDir.'/styles.js', $jsPath . '/styles.js');
        $filesystem->copy($vendorDir.'/contents.css', $jsPath . '/contents.css');   // css loaded by CKEditor
        $finder = new Finder();
        $finder->files()->in($vendorDir.'/lang')->name('*.js');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/lang/' . $file->getRelativePathname());
        }
        $finder = new Finder();
        $finder->files()->in($vendorDir.'/plugins');
        foreach ($finder as $file) {
            $filesystem->copy($file, $jsPath . '/plugins/' . $file->getRelativePathname());
        }

        return $success;
    }

    protected function getVitaletsXEditableAssets($output)
    {
        $success = true;

        $filesystem = $this->getContainer()->get('filesystem');

        $vendorDir = $this->getContainer()->get('kernel')->getRootDir().'/../vendor/vitalets/x-editable';
        foreach(['bootstrap-editable', 'bootstrap3-editable'] as $version) {
            $versionDir = $vendorDir . '/dist/' . $version;

            if ('bootstrap-editable' == $version) {
                $version = 'bootstrap2-editable';
            }

            # css
            $cssPath = $this->initializeDirectory('css/'.$version);
            $finder = new Finder();
            $finder->files()->in($versionDir.'/css')->name('*.css');
            foreach ($finder as $file) {
                $content = file_get_contents($file->getPathname());
                // replace images url
                $content = str_replace('../img', '/bundles/bootstrapp/images/'.$version, $content);
                file_put_contents($cssPath . '/' . $file->getRelativePathname(), $content);
            }

            # images
            $imagesPath = $this->initializeDirectory('images/'.$version);
            $finder = new Finder();
            $finder->files()->in($versionDir.'/img')->name('*.gif')->name('*.jpg')->name('*.png');
            foreach ($finder as $file) {
                $filesystem->copy($file, $imagesPath . '/' . $file->getRelativePathname());
            }

            # js
            $jsPath = $this->initializeDirectory('js/'.$version);
            $finder = new Finder();
            $finder->files()->in($versionDir.'/js')->name('*.js');
            foreach ($finder as $file) {
                $filesystem->copy($file, $jsPath . '/' . $file->getRelativePathname());
            }
        }

        return $success;
    }
}