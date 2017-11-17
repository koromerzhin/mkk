<?php

namespace Mkk\SiteBundle\Modal;

use Mkk\SiteBundle\Lib\LibModal;

class ActionBooleanModal extends LibModal
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
        if (0 !== substr_count($content, 'BtnBool')) {
            $html = $this->templating->render(
                'MkkSiteBundle:Include:modal/boolean/true.html.twig'
            );

            $html = str_replace(
                'BtnSaveConfirm',
                'BtnBoolTrueConfirm',
                $html
            );

            $content = str_replace('<modal>', "<modal>{$html}", $content);
            $html    = $this->templating->render(
                'MkkSiteBundle:Include:modal/boolean/false.html.twig'
            );

            $html = str_replace(
                'BtnSaveConfirm',
                'BtnBoolFalseConfirm',
                $html
            );

            $content = str_replace('<modal>', "<modal>{$html}", $content);
        }

        return $content;
    }
}
