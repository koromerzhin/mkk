<?php

namespace Mkk\SiteBundle\Listener\Traits;

use Symfony\Component\Intl\Intl;

trait ResponseTrait
{
    /**
     * Initalisation templates pour twig.
     *
     * @return void
     */
    private function setTwigTemplates(): void
    {
        $bundles                       = $this->container->getParameter('kernel.bundles');
        $this->fichier['Tel']          = 'MkkSiteBundle:Include:telephone.html.twig';
        $this->fichier['AdminTel']     = 'MkkAdminBundle:Include:telephone.html.twig';
        $this->fichier['Country']      = 'MkkSiteBundle:Include:country.html.twig';
        $this->fichier['AdminCountry'] = 'MkkAdminBundle:Include:country.html.twig';
        $this->fichier['Diaporama']    = 'MkkSiteBundle:Include:diaporama.html.twig';
        $this->fichier['Email']        = 'MkkSiteBundle:Include:email.html.twig';
        $this->fichier['AdminEmail']   = 'MkkAdminBundle:Include:email.html.twig';
        foreach ($bundles as $code => $bundle) {
            if (0 !== substr_count($code, 'SiteBundle')) {
                $dossier                    = str_replace('\\', '/', $bundle);
                $dossier                    = substr($dossier, 0, strrpos($dossier, '/'));
                list($emplacement, $partie) = explode('/', $dossier);
                unset($partie);
                $this->setFileTemplates($emplacement, 'telephone', 'Tel', 1);
                $this->setFileTemplates($emplacement, 'telephone', 'AdminTel', 0);
                $this->setFileTemplates($emplacement, 'country', 'Country', 1);
                $this->setFileTemplates($emplacement, 'country', 'AdminCountry', 0);
                $this->setFileTemplates($emplacement, 'diaporama', 'Diaporama', 1);
                $this->setFileTemplates($emplacement, 'email', 'Email', 1);
                $this->setFileTemplates($emplacement, 'email', 'AdminEmail', 0);
            }
        }
    }

    /**
     * Set le template.
     *
     * @param string $emplacement dossier
     * @param string $type        type de fichier
     * @param string $code        pour this->fichier
     * @param int    $partie      1/ 0 (1 = Public | 0 = Admin)
     *
     * @return void
     */
    private function setFileTemplates(string $emplacement, string $type, string $code, int $partie): void
    {
        if (1 === $partie) {
            $namespace = 'Site';
        } else {
            $namespace = 'Admin';
        }

        $fichier = "../src/{$emplacement}/{$namespace}Bundle/Resources/views/Include/{$type}.html.twig";
        if (is_file($fichier)) {
            $this->fichier[$code] = "{$emplacement}{$namespace}Bundle:Include:{$type}.html.twig";
        }
    }

    /**
     * Lazy-load image.
     *
     * @param string $content Code HTML
     *
     * @return string
     */
    private function imgLazyLoad(string $content): string
    {
        $content = str_replace('<img src', '<img data-src', $content);

        return $content;
    }

    /**
     * Enleve les espaces / tabulations.
     *
     * @param string $content Code HTML
     *
     * @return string
     */
    private function obclean(string $content): string
    {
        if ('dev' !== $this->container->get('kernel')->getEnvironment()) {
            $content = str_replace(['<modal>', '</modal>'], '', $content);
            $content = str_replace(["\n", "\t"], '', $content);
        }

        return $content;
    }

    /**
     * Ajoute les modals.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    private function addModal(string $content): string
    {
        $servicesID = $this->container->getServiceIds();
        foreach ($servicesID as $service) {
            if (0 !== substr_count($service, "\Modal")) {
                $modal   = $this->container->get($service);
                $content = $modal->html($content);
            }
        }

        return $content;
    }

    /**
     * Ajoute les champs upload et download quand le formulaire d'upload existe.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    private function addUploadFormTmpl(string $content): string
    {
        if (0 !== substr_count($content, 'EmplacementUpload')) {
            $twiguploadtmpl = [
                'upload'   => '',
                'download' => '',
            ];

            $folder = '../';
            $file   = $folder . 'src/Mkk/SiteBundle/Resources/views/Tmpl/upload.tmpl';
            if (is_file($file)) {
                $twiguploadtmpl['upload'] = str_replace(["\n", "\t"], '', file_get_contents($file));
            }

            $file = $folder . 'src/Mkk/SiteBundle/Resources/views/Tmpl/download.tmpl';
            if (is_file($file)) {
                $twiguploadtmpl['download'] = str_replace(["\n", "\t"], '', file_get_contents($file));
            }

            $html = $this->templating->render(
                'MkkSiteBundle:Include:upload.html.twig',
                [
                    'twiguploadtmpl' => $twiguploadtmpl,
                ]
            );

            $content = str_replace('</body>', $html . '</body>', $content);
        }

        return $content;
    }

    /**
     * Modifie l'affichage du formulaire.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    private function modifForm(string $content): string
    {
        if (0 !== substr_count($content, '<body')) {
            $doc = new \DOMDocument();
            libxml_use_internal_errors(TRUE);
            $doc->loadHTML($content);
            $forms = $doc->getElementsByTagName('form');
            foreach ($forms as $form) {
                $class      = $form->getAttribute('class');
                $condition0 = ('' === $class);
                $condition1 = (0 === substr_count($class, 'form-horizontal'));
                $condition2 = (0 === substr_count($class, 'form-inline'));
                $condition3 = (0 === substr_count($class, 'form-vertical'));
                if ($condition0 || ($condition1 && $condition2 && $condition3)) {
                    $class = $class . ' form-horizontal';
                }

                if ('form-vertical' === $class) {
                    $class = str_replace('form-vertical', '', $class);
                }

                $class = trim($class);
                $form->setAttribute('class', $class);
            }

            /**
             * WIP pour turbolinks
             * if(count($forms)!=0){
             *     $body = $doc->getElementsByTagName('form');
             *     foreach($body as $row){
             *         $row->setAttribute('data-no-turbolink', "true");
             *     }
             * }.
             */
            $content = $doc->saveHTML();
        }

        return $content;
    }

    /**
     * Modifier l'affichage du content.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    private function modifierBoolean($content): string
    {
        $tab = explode('{boolean}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/boolean}')) {
                $oldCode = substr($row, 0, strpos($row, '{/boolean}'));
                $url     = '';
                $code    = $oldCode;
                $id      = '';
                if (0 !== substr_count($oldCode, '|')) {
                    $split = explode('|', $oldCode);
                    $code  = $split[0];
                    $url   = $split[1];
                    $id    = $split[2];
                }

                if ('' === $code) {
                    $code = 0;
                }

                $html = $this->templating->render(
                    'MkkSiteBundle:Include:boolean.html.twig',
                    [
                        'code' => $code,
                        'id'   => $id,
                        'url'  => $url,
                    ]
                );

                $content = str_replace('{boolean}' . $oldCode . '{/boolean}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage de la date.
     *
     * @param string $content code HTML
     * @param string $locale  code du pays
     *
     * @return string
     */
    private function modifierDay(string $content, string $locale): string
    {
        $tab = explode('{day}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/day}')) {
                $code = substr($row, 0, strpos($row, '{/day}'));

                $html = $this->templating->render(
                    'MkkSiteBundle:Include:day.html.twig',
                    [
                        'code'   => $code,
                        'locale' => $locale,
                    ]
                );

                $content = str_replace('{day}' . $code . '{/day}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage du temps.
     *
     * @param string $content code HTML
     * @param string $locale  code du pays
     *
     * @return string
     */
    private function modifierTemps(string $content, string $locale): string
    {
        $tab = explode('{temps}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/temps}')) {
                $code = substr($row, 0, strpos($row, '{/temps}'));

                $html = $this->templating->render(
                    'MkkSiteBundle:Include:temps.html.twig',
                    [
                        'code'   => $code,
                        'locale' => $locale,
                    ]
                );

                $content = str_replace('{temps}' . $code . '{/temps}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage de l'heure.
     *
     * @param string $content code HTML
     * @param string $locale  code du pays
     *
     * @return string
     */
    private function modifierHeure(string $content, string $locale): string
    {
        $tab = explode('{heure}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/heure}')) {
                $code = substr($row, 0, strpos($row, '{/heure}'));

                $html = $this->templating->render(
                    'MkkSiteBundle:Include:heure.html.twig',
                    [
                        'code'   => $code,
                        'locale' => $locale,
                    ]
                );

                $content = str_replace('{heure}' . $code . '{/heure}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage du pays.
     *
     * @param string $content code HTML
     * @param string $locale  code du pays
     * @param string $twig    template a utiliser
     *
     * @return string
     */
    private function modifCountry(string $content, string $locale, string $twig): string
    {
        $tab = explode('{country}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/country}')) {
                $code    = substr($row, 0, strpos($row, '{/country}'));
                $intl    = Intl::getRegionBundle()->getCountryNames($locale);
                $country = $intl[$code] ?? '';

                $html = $this->templating->render(
                    $twig,
                    [
                        'code'    => $code,
                        'country' => $country,
                    ]
                );

                $content = str_replace('{country}' . $code . '{/country}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage de l'email.
     *
     * @param string $content code HTML
     * @param string $twig    template a utiliser
     *
     * @return string
     */
    private function modifEmail(string $content, string $twig): string
    {
        $tab = explode('{lienemail}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/lienemail}')) {
                $adresse = substr($row, 0, strpos($row, '{/lienemail}'));

                $html = $this->templating->render(
                    $twig,
                    [
                        'mail' => $adresse,
                    ]
                );

                $content = str_replace('{lienemail}' . $adresse . '{/lienemail}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifier l'affichage du numéro de téléphone.
     *
     * @param string $content code HTML
     * @param string $locale  code du pays
     * @param string $twig    template a utiliser
     *
     * @return string
     */
    private function modifTelephone(string $content, string $locale, string $twig): string
    {
        $tab = explode('{lientel}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/lientel}')) {
                $numero = trim(substr($row, 0, strpos($row, '{/lientel}')));
                $json   = $this->telephoneService->verif($numero, $locale);
                $num    = $numero;
                if (isset($json['num'])) {
                    $num = $json['num'];
                }

                $html = $this->templating->render(
                    $twig,
                    [
                        'country' => Intl::getRegionBundle()->getCountryNames(),
                        'locale'  => strtoupper($locale),
                        'data'    => $json,
                    ]
                );

                $content = str_replace('{lientel}' . $numero . '{/lientel}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Modifie la vidéo.
     *
     * @param string $content code HTML
     *
     * @return string
     */
    private function modifVideo(string $content): string
    {
        $tab = explode('{video}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/video}')) {
                $url  = substr($row, 0, strpos($row, '{/video}'));
                $json = $this->oembed($url);
                $html = '';
                if (isset($json['html'])) {
                    $html = $json['html'];
                }

                $content = str_replace('{video}' . $url . '{/video}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Transforme un lien en code html oembed.
     *
     * @param string $lien URL
     *
     * @return array
     */
    private function oembed(string $lien)
    {
        $tab = [];
        if (1 === substr_count($lien, 'vimeo')) {
            $url = 'http://vimeo.com/api/oembed.json?url=';
        } elseif (1 === substr_count($lien, 'youtube') || 1 === substr_count($lien, 'youtu.be')) {
            $url = 'http://www.youtube.com/oembed?format=json&url=';
        } elseif (1 === substr_count($lien, 'ifttt')) {
            $url = 'https://ifttt.com/oembed.json?url=';
        } elseif (1 === substr_count($lien, 'flickr')) {
            $url = 'https://www.flickr.com/services/oembed.json?url=';
        }

        if (isset($url)) {
            $url = $url . urlencode($lien);
            $tab = json_decode(file_get_contents($url), TRUE);
        }

        return $tab;
    }

    /**
     * Modifie la galerie
     * Remplace {galerie}1{/galerie} par l'entité galerie.
     *
     * @param string $content code HTML
     * @param string $twig    Template A utiliser
     *
     * @return string
     */
    private function modifGalerie(string $content, string $twig): string
    {
        $tab = explode('{galerie}', $content);
        foreach ($tab as $row) {
            if (0 !== substr_count($row, '{/galerie}')) {
                $value = substr($row, 0, strpos($row, '{/galerie}'));
                $html  = '';
                if (is_numeric($value)) {
                    $data = $this->modifGalerieInt($value);
                } elseif (is_dir($value)) {
                    $data = $this->modifGalerieFolder($value);
                }

                if (isset($data) && 0 !== count($data['images'])) {
                    $data['md5'] = md5(uniqid());
                    $html        = $this->templating->render(
                        $twig,
                        $data
                    );
                }

                $content = str_replace('{galerie}' . $value . '{/galerie}', $html, $content);
            }
        }

        return $content;
    }

    /**
     * Récupére les fichiers liés au DiaporamaManager.
     *
     * @param int $value folder
     *
     * @return array
     */
    private function modifGalerieInt(int $value): array
    {
        $data                = [];
        $diaporamaManager    = $this->container->get('bdd.diaporama_manager');
        $diaporamaRepository = $diaporamaManager->getRepository();
        $diaporama           = $diaporamaRepository->find($value);
        if ($diaporama) {
            $data = [
                'images' => $diaporama->getImages(),
            ];
        }

        return $data;
    }

    /**
     * Récupére les fichiers liés au dossier.
     *
     * @param string $value folder
     *
     * @return array
     */
    private function modifGalerieFolder(string $value): array
    {
        $fichiers = glob($value . '/*');
        foreach ($fichiers as $i => $file) {
            $file = str_replace('//', '/', $file);
            if (!is_file($file)) {
                unset($fichiers[$i]);
            } else {
                $fichiers[$i] = substr($file, strpos($file, $value));
            }
        }

        $data = [
            'images' => $fichiers,
        ];

        return $data;
    }
}
