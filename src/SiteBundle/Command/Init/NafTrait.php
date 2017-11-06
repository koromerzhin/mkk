<?php

namespace Mkk\SiteBundle\Command\Init;

use Symfony\Component\Console\Output\OutputInterface;

trait NafTrait
{

        /**
         * récupére les données du fichier excel
         *
         * @param     OutputInterface $output  ouput
         * @param     string          $fichier fichier
         * @param     integer         $ligne   numero de la ligne
         * @return    array
         */
    public function recuperDataXls(OutputInterface $output, $fichier, $ligne): array
    {
        $container = $this->getContainer();
        $phpexcel  = $container->get('phpexcel');
        $data      = [];
        $fichier   = 'src/Mkk/SiteBundle/Data/naf/' . $fichier . '.xls';
        if (is_file($fichier)) {
            $phpExcelObject = $phpexcel->createPHPExcelObject($fichier);
            $sheet          = $phpExcelObject->getActiveSheet();
            $output->writeln($fichier);
            foreach ($sheet->getRowIterator() as $i => $row) {
                if ($i > $ligne) {
                    $tab = [];
                    foreach ($row->getCellIterator() as $cell) {
                        $val   = $cell->getValue();
                        $tab[] = $val;
                    }

                    $data[] = $tab;
                }
            }
        }

        return $data;
    }


        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setInitNaf(OutputInterface $output): void
    {
        $this->setNafSection($output);
        $this->setNafDivision($output);
        $this->setNafGroupe($output);
        $this->setNafClasse($output);
        $this->setNafSousClasse($output);
        $this->setNaf($output);
    }

        /**
         * Rempli les données
         *
         * @param     array  $data data
         * @param string $nom  nom
         * @return    void
         */
    private function remplirNafDefault($data, $nom): void
    {
        $container  = $this->getContainer();
        $manager    = $container->get('bdd.' . $nom . '_manager');
        $repository = $manager->getRepository();
        $all        = $repository->findAll();
        if (count($all) != count($data)) {
            foreach ($data as $row) {
                if ($row[0] != '') {
                    $entity = $repository->findOneBy(['code' => $row[0]]);
                    if (! $entity) {
                        $table  = $manager->getTable();
                        $entity = new $table();
                        $entity->setCode($row[0]);
                        $entity->setLibelle($row[1]);
                        $manager->persistAndFlush($entity);
                    }
                }
            }
        }
    }

        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNafSection(OutputInterface $output): void
    {
        $fichier = 'naf2008_liste_n1';
        $data    = $this->recuperDataXls($output, $fichier, 3);
        $this->remplirNafDefault($data, 'nafsection');
    }

        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNafDivision(OutputInterface $output): void
    {
        $fichier = 'naf2008_liste_n2';
        $data    = $this->recuperDataXls($output, $fichier, 3);
        $this->remplirNafDefault($data, 'nafdivision');
    }

        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNafGroupe(OutputInterface $output): void
    {
        $fichier = 'naf2008_liste_n3';
        $data    = $this->recuperDataXls($output, $fichier, 3);
        $this->remplirNafDefault($data, 'nafgroupe');
    }

        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNafClasse(OutputInterface $output): void
    {
        $fichier = 'naf2008_liste_n4';
        $data    = $this->recuperDataXls($output, $fichier, 3);
        $this->remplirNafDefault($data, 'nafclasse');
    }

        /**
         * set
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNafSousClasse(OutputInterface $output): void
    {
        $fichier = 'naf2008_liste_n5';
        $data    = $this->recuperDataXls($output, $fichier, 3);
        $this->remplirNafDefault($data, 'nafsousclasse');
    }

        /**
         * set (WIP)
         *
         * @param     OutputInterface $output ouput
         * @return    void
         */
    private function setNaf(OutputInterface $output): void
    {
        $fichier = 'naf2008_5_niveaux';
        $data    = $this->recuperDataXls($output, $fichier, 1);
                unset($data);
    }
}
