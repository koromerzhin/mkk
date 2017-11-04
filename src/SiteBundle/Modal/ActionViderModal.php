<?php

namespace Mkk\SiteBundle\Modal;

use Mkk\SiteBundle\Lib\LibModal;

class ActionViderModal extends LibModal
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
        if (0 !== substr_count($content, 'BoutonVider')) {
            $html = $this->templating->render(
                'MkkSiteBundle:Include:modal/vider.html.twig'
            );

            $html = str_replace(
                'BtnSaveConfirm',
                'BtnViderConfirm',
                $html
            );

            $content = str_replace('<modal>', "<modal>{$html}", $content);
        }

        return $content;
    }
}
