<?php
namespace nmariani\Bundle\BootstrappBundle\Composer;

use Symfony\Component\Process\Process,
    Symfony\Component\Process\PhpExecutableFinder;

/**
 * @author Nathanaël Mariani <github@nmariani.fr>
 */
class ScriptHandler
{
    public static function installAssets($event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        if(empty($appDir))
            $appDir = "app";

        if (!is_dir($appDir)) {
            echo 'The symfony-app-dir ('.$appDir.') was not found in '.getcwd().', can not install assets.'.PHP_EOL;
            return;
        }

        static::executeCommand($event, $appDir, 'bootstrapp:install');
    }

    protected static function executeCommand($event, $appDir, $cmd)
    {
        $phpFinder = new PhpExecutableFinder;
        $php = escapeshellarg($phpFinder->find());
        $console = escapeshellarg($appDir.'/console');
        if ($event->getIO()->isDecorated()) {
            $console.= ' --ansi';
        }

        $process = new Process($php.' '.$console.' '.$cmd, null, null, null, 300);
        $process->run(function ($type, $buffer) { echo $buffer; });
    }
}
