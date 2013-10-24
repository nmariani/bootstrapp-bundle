<?php
namespace nmariani\Bundle\BootstrappBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class UseIconsCommand extends ContainerAwareCommand
{
    private $sourcePath;
    private $targetPath;
    private $targetFile;
    private $bundle;
    private $files;
    private $rules;

    protected function configure()
    {
        $this
            ->setName('bootstrapp:use-icons')
            ->setDescription('Use given icons')
            ->addArgument('bundle', InputArgument::REQUIRED, 'Name of the bundle into which file will be generated')
            ->addArgument('iconsets', InputArgument::IS_ARRAY, 'Icons sets to be installed')
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL, 'Path of file to be generated (relative to bundle dir)', '/Resources/public/less')
            ->addOption('filename', 'f', InputOption::VALUE_OPTIONAL, 'Name of file to be generated', 'bootstrapp-icons.less')
            ->addOption('clear', 'c', InputOption::VALUE_NONE, 'Clear files before installing new icons')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get command args and options
        if(!$this->bundle = $this->getContainer()->get('kernel')->getBundle($input->getArgument('bundle'))) {
            throw new \InvalidArgumentException('Bundle "'.$input->getArgument('bundle').'" does not exist or it is not enabled.');
        }
        $this->targetPath = $this->bundle->getPath().$input->getOption('path');
        if(!is_dir($this->targetPath)) {
            throw new \InvalidArgumentException('Invalid Path "'.$this->targetPath.'"! Please create path and relaunch.');
        }
        $filename = $input->getOption('filename');
        $iconsets = $input->getArgument('iconsets');
        $clear = $input->getOption('clear');

        // initialize vars
        $this->sourcePath = $this->getContainer()
                            ->get('kernel')
                            ->getBundle('BootstrappBundle')
                            ->getPath()
                          .'/Resources/public/less/icons';
        $this->targetFile = $this->targetPath . '/' . $filename;
        $this->files = array();
        $this->rules = array();
        $writeFile = false;

        if(false==$clear) {
            $this->loadTargetFile();
            if(count($iconsets)==0) {
                throw new \InvalidArgumentException('The "iconset" argument does not exist.');
            }
        } else {
            $writeFile = (count($iconsets)==0);
        }

        foreach($iconsets as $iconset) {
            $nb = $this->parse($iconset);
            if($nb>0) {
                $output->writeln('<info>Success : '.$nb.' '.$iconset.' icons installed!</info>');
                $writeFile = true;
            } elseif($nb==0) {
                $output->writeln('<comment>No changes : '.$nb.' '.$iconset.' icons installed!</comment>');
            } else {
                $output->writeln('<error>Error : unknown icons set "'.$iconset.'"!</error>');
            }
        }

        if(true===$writeFile) {
            $this->writeTargetFile();

            $output->writeln("<info>\nSuccess : you can now import the generated file in your main bundle less file!</info>");
            $output->writeln('<comment>@import "'.basename($this->targetFile).'";</comment>');
        }
    }

    protected function loadTargetFile(){
        if(is_file($this->targetFile)) {
            $content = file_get_contents($this->targetFile);

            // parse import @import {file}; - ex: @import "icons/glyphicons.less";
            preg_match_all('/@import\s*\"?([\w\/.]+)\"?;/', $content, $matches, PREG_SET_ORDER);
            foreach($matches as $match) {
                $this->files[] = $match[1];
            }

            // parse rules .{$iconset}-xxx(){} - ex: .glyphicons-user
            preg_match_all('/(\.icon(?:(?:-\w*)+))\s*\{(.*)\}/', $content, $matches, PREG_SET_ORDER);
            foreach($matches as $match) {
                $this->rules[$match[1]] = $match[2];
            }
        }
    }

    protected function writeTargetFile(){
        // relative path to icons less files
        $iconsPath = $this->relativePath($this->targetPath, $this->sourcePath);
        $variablesPath = $this->relativePath($this->targetPath, realpath($this->sourcePath.'/..'));

        // import variables.less file to allow the use of common size, colors, ...
        $import = '@import "'.$variablesPath.'/variables.less";';
        foreach($this->files as $file) {
            // import icons set less file (glyphicons, entypo, fontawesome, metrize, ...)
            $import .= "\n".'@import "'.$iconsPath.'/'.$file.'";';
        }

        $rules = '';
        ksort($this->rules);
        foreach($this->rules as $selector => $value) {
            $rules .= "\n"
                    .str_pad($selector, 36, ' ')
                    .' { '
                    .str_pad($value, 36, ' ')
                    .' }';
        }

        file_put_contents($this->targetFile, <<<EOF
/*!
 * icons.less v1.0.0
 *
 * Copyright 2012 n@mariani
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$import

$rules
EOF
        );
    }

    /**
     * Return number of icons to be installed or -1 if any error occurred
     * @param string $iconset
     * @return int
     */
    protected function parse($iconset) {
        $nb = 0;
        $file = $iconset.'.less';
        if(in_array($file, $this->files)) {
            return 0;
        }
        if( false===($content = @file_get_contents($this->sourcePath.'/'.$file))) {
            return -1;
        }

        // search .{$iconset}-xxx(){} - ex: .glyphicon-user
        preg_match_all('/\.'.$iconset.'((-\w*)+)\(\)/', $content, $matches, PREG_SET_ORDER);
        foreach($matches as $match) {
            $mixin =$match[0];
            $selector = '.icon'.$match[1];

            if(!isset($this->rules[$selector])) {
                $this->rules[$selector] = $mixin.';';
                $nb++;
            }
        }

        if($nb>0) {
            $this->files[] = $file;
        }

        return $nb;
    }

    private function relativePath($from, $to, $ps = DIRECTORY_SEPARATOR) {
        $arFrom = explode($ps, rtrim($from, $ps));
        $arTo = explode($ps, rtrim($to, $ps));
        while(count($arFrom) && count($arTo) && ($arFrom[0] == $arTo[0])){
            array_shift($arFrom);
            array_shift($arTo);
        }
        return str_pad("", count($arFrom) * 3, '..'.$ps).implode($ps, $arTo);
    }
}
