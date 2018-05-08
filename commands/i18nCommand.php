<?php

namespace CoreOGraphy\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;


/**
 * i18nCommand
 *
 * This script will merge the i18n files
 *
 * @package Core-o-Graphy
 */
class i18nCommand extends Command {
    
    /**
     * configure
     *
     * @package Core-o-Graphy
     */
    protected function configure () {
        $this->setName ('app:i18n');
    }
    
    
    /**
     * execute
     *
     * @param $input InputInterface
     * @param $output OutputInterface
     *
     * @package Core-o-Graphy
     */
    protected function execute (InputInterface $input, OutputInterface $output) {
        
        /** @var $langs Array */
        $langs = [];
        
        
        /** @var $finder Finder */
        $finder = new Finder ();
        
        
        /** @var $fileSystem Filesystem */
        $fileSystem = new Filesystem ();
        
        
        // Get lang files within the controllers
        $finder->files()->in ('controllers/*/lang/')->name ('*.json');;
        
        
        // Get every file
        foreach ($finder as $file) {
            
            /** @var $lang_code String */
            $lang_code = str_replace (['lang_', '.json'], '', $file->getRelativePathname ());
            
            
            /** @var $lang_content Array */
            $lang_content = json_decode ($file->getContents (), true);
            
            
            // Attach to an array
            $langs[$lang_code] = $lang_content + (isset ($langs[$lang_code]) ? $langs[$lang_code] : []);
            
        }
        
        
        // Write combined files in disk
        foreach ($langs as $code => $translations) {
            
            /** @var $filename String */
            $filename = './lang/lang_' . $code . '.json';
            
            
            /** @var $content JSON */
            $content = json_encode ($translations, JSON_PRETTY_PRINT);
            
            
            // Store
            $fileSystem->dumpFile ($filename, $content);
            $fileSystem->chmod ($filename, 0755);
            
        }
        
        
        // Inform the user
        $output->writeln ('Done');
        
    }
}