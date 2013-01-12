<?php
namespace nmariani\Bundle\BootstrappBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class ClearCommand extends ContainerAwareCommand
{
    protected $resourcesPath;

    protected function configure()
    {
        $this
            ->setName('bootstrapp:clear')
            ->setDescription('Delete any css and js in BootstrappBundle Resources')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->resourcesPath = $this->getContainer()->get('kernel')->getBundle('BootstrappBundle')->getPath()
                                .'/Resources/public';

        $output->writeln('<comment>Removing Twitter Bootstrap assets...</comment>');
        if(true === $this->clearTwitterBootstrapAssets($output)) {
            $output->writeln('<info>Success, Twitter Bootstrap assets removed!</info>');
        } else {
            $output->writeln('<error>Error : Twitter Bootstrap assets remove failed!</error>');
        }

        $output->writeln('<comment>Removing Entypo assets...</comment>');
        if(true === $this->clearEntypoAssets($output)) {
            $output->writeln('<info>Success, Entypo assets removed!</info>');
        } else {
            $output->writeln('<error>Error : Entypo assets remove failed!</error>');
        }
    }

    protected function clearTwitterBootstrapAssets($output) {
        $finder = new Finder();
        $finder->files()
            ->in([  $this->resourcesPath.'/images/bootstrap',
                    $this->resourcesPath.'/js/bootstrap',
                    $this->resourcesPath.'/less/bootstrap'
                ]);
        foreach ($finder as $file) {
            $output->writeln('<comment>Delete '. $file->getFilename() .'</comment>');
            unlink($file->getRealPath());
        }

        $glyphiconsFile = $this->resourcesPath.'/less/icons/glyphicons.less';
        if(is_file($glyphiconsFile)) {
            $output->writeln('<comment>Delete '. $glyphiconsFile .'</comment>');
            unlink($glyphiconsFile);
        }

        return true;
    }

    protected function clearEntypoAssets($output) {
        $finder = new Finder();
        $finder->files()
            ->in([  $this->resourcesPath.'/fonts',
                    $this->resourcesPath.'/less/icons'
                ])
            ->name('entypo.*');
        foreach ($finder as $file) {
            unlink($file->getRealPath());
            $output->writeln('<comment>Delete '. $file->getFilename() .'</comment>');
        }

        return true;
    }
}
