<?php

namespace Mkk\SiteBundle\Modal;

use Mkk\SiteBundle\Lib\LibModal;

class ActionRequiredModal extends LibModal
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
        if (0 !== substr_count($content, 'required')) {
            $html = $this->templating->render(
                'MkkSiteBundle:Include:modal/required.html.twig'
            );

            $content = str_replace('<modal>', "<modal>{$html}", $content);
        }

        return $content;
    }
}
