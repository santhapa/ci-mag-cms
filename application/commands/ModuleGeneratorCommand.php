<?php

namespace commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Input\InputArgument;

use InvalidArgumentException;

/**
 * Load data fixtures from modules.
 */
class ModuleGeneratorCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('mag:module:create')
            ->setDescription('Create module structure.')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of module');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = $input->getArgument('name');
        if(!$module) throw new \Exception("<comment>Module name is missing</comment>", 1);

        if(!preg_match('/^[a-zA-Z0-9_]*$/', $module))
            throw new \Exception("Invalid name, allowed only alphabets, numbers and underscore.", 1);

            
        $output->writeln('<info>Creating module structure...</info>');

        $modulePath = __DIR__."/../modules/".$module;

        if(is_dir($modulePath)) throw new \Exception("Module already exits.", 1);
        mkdir($modulePath, 0777);

        $folders = array('config', 'controllers', 'views', 'models', 'helpers', 'fixtures', 'manager', 'services');

        $dialog = $this->getHelperSet()->get('dialog');
        if ($dialog->askConfirmation($output, '<question>Do you like to create whole structure? (Y/N)</question>')) {
            foreach ($folders as $folder) {
                mkdir($modulePath.'/'.$folder, 0777);
                $output->writeln('<info>'.ucfirst($folder).' created.</info>');
            }
        }
        else{
            foreach ($folders as $folder) {
                if($dialog->askConfirmation($output, '<question>Create '.ucfirst($folder).'? (Y/N)</question>')) {
                    mkdir($modulePath.'/'.$folder, 0777);
                    $output->writeln('<info>'.ucfirst($folder).' created.</info>');
                }
            }
        }

        $output->writeln('<info>Module created successfully.</info>');

    }
}
