<?php

namespace Mkk\AdminBundle\Modal;

use Mkk\SiteBundle\Lib\LibModal;

class EtablissementModal extends LibModal
{
    /**
     * Ajoute du code HTML.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    public function html(string $content): string
    {
        $test1 = (0 !== substr_count($content, 'LienAjouterEtablissement'));
        $test2 = (0 !== substr_count($content, 'BoutonNewEtablissement'));
        if ($test1 || $test2) {
            $twig    = 'MkkAdminBundle:Etablissement:modal/new.html.twig';
            $html    = $this->templating->render($twig);
            $content = str_replace('<modal>', "<modal>{$html}", $content);
        }

        return $content;
    }
}
