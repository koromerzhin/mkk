<?php

namespace Mkk\SiteBundle\Modal;

use Mkk\SiteBundle\Lib\LibModal;

class ActionDeleteModal extends LibModal
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
        if (0 !== substr_count($content, 'BoutonSupprimer')) {
            $html = $this->templating->render(
                'MkkSiteBundle:Include:modal/delete.html.twig'
            );

            $html = str_replace(
                'BtnSaveConfirm',
                'BtnDelConfirm',
                $html
            );

            $content = str_replace('<modal>', "<modal>{$html}", $content);
        }

        return $content;
    }
}
