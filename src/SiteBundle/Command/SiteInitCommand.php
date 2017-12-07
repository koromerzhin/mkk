<?php

namespace Mkk\SiteBundle\Command;

use Mkk\SiteBundle\Lib\ContainerAwareCommandLib;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteInitCommand extends ContainerAwareCommandLib
{
    /**
     * Commande qui l'identifie.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('mkk:site:init');
    }

    /**
     * Execution de la commande.
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->initCommand();
        $output->writeln('Initialisation des dossiers');
        if (!is_dir('web/tmp')) {
            mkdir('web/tmp');
        }

        if (!is_dir('web/tmp/geonames')) {
            mkdir('web/tmp/geonames');
        }

        $this->setFolderFichiers();

        if (!is_dir('web/filemanager') && is_dir('../public/filemanager')) {
            mkdir('web/filemanager');
            $this->cpy(
                '../public/filemanager',
                'web/filemanager'
            );
        }

        $paramManager    = $this->container->get('bdd.param_manager');
        $paramRepository = $paramManager->getRepository();
        $paramEntity     = $paramManager->getTable();
        $robots          = $paramRepository->findOneByCode('robotstxt');
        if (!$robots) {
            $robots = new $paramEntity();
            $robots->setCode('robotstxt');
            $valeur = file_get_contents('vendor/koromerzhin/mkk/src/SiteBundle/Data/robots.txt');
            $robots->setValeur($valeur);
            $paramManager->persistAndFlush($robots);
        } else {
            $valeur = $robots->getValeur();
        }

        file_put_contents('web/robots.txt', $valeur);

        $robots = $paramRepository->findOneByCode('crontab');
        if (!$robots) {
            $crontab = new $paramEntity();
            $crontab->setCode('crontab');
            $crontab->setValeur('');
            $paramManager->persistAndFlush($crontab);
        } else {
            $valeur = $robots->getValeur();
        }

        file_put_contents('web/crontab.sh', $valeur);

        unset($input, $output);
    }

    /**
     * Init dossier web/fichiers.
     *
     * @return void
     */
    private function setFolderFichiers(): void
    {
        if (!is_dir('web/fichiers')) {
            mkdir('web/fichiers');
        }

        if (!is_dir('web/fichiers/documents')) {
            mkdir('web/fichiers/documents');
        }

        if (!is_dir('web/fichiers/mailer')) {
            mkdir('web/fichiers/mailer');
        }

        if (!is_dir('web/fichiers/user')) {
            mkdir('web/fichiers/user');
        }

        if (!is_dir('web/fichiers/user/avatar')) {
            mkdir('web/fichiers/user/avatar');
        }

        if (!is_dir('web/fichiers/geonames')) {
            $this->rrmdir('web/fichiers/geonames');
        }

        if (is_dir('web/fichiers/thumbnail')) {
            $this->rrmdir('web/fichiers/thumbnail');
        }
    }

    /**
     * Copie fichier.
     *
     * @param string $source source
     * @param string $dest   destination
     *
     * @return void
     */
    private function cpy($source, $dest): void
    {
        if (is_dir($source)) {
            $dirHandle = opendir($source);
            while ($file = readdir($dirHandle)) {
                if ('.' !== $file && '..' !== $file) {
                    if (is_dir($source . '/' . $file)) {
                        if (!is_dir($dest . '/' . $file)) {
                            mkdir($dest . '/' . $file);
                        }

                        $this->cpy($source . '/' . $file, $dest . '/' . $file);
                    } else {
                        copy($source . '/' . $file, $dest . '/' . $file);
                    }
                }
            }

            closedir($dirHandle);
        } else {
            copy($source, $dest);
        }
    }

    /**
     * Supprimer un dossier.
     *
     * @param string $dir dossier
     *
     * @return void
     */
    private function rrmdir($dir): void
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ('.' !== $object && '..' !== $object) {
                    if ('dir' === filetype($dir . '/' . $object)) {
                        $this->rrmdir($dir . '/' . $object);
                    } else {
                        unlink($dir . '/' . $object);
                    }
                }
            }

            reset($objects);
            rmdir($dir);
        }
    }
}
