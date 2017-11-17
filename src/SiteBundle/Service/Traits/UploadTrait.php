<?php

namespace Mkk\SiteBundle\Service\Traits;

trait UploadTrait
{
    /**
     * @Recupere le code md5
     *
     * @return string
     */
    private function setMd5(): string
    {
        $request     = $this->request;
        $routeparams = $request->attributes->get('_route_params');
        if (isset($routeparams['md5'])) {
            $md5 = $routeparams['md5'];
        } else {
            $get = $request->query->all();
            if (isset($get['md5'])) {
                $md5 = $get['md5'];
            }
        }

        return $md5;
    }

    /**
     * Genere les options.
     *
     * @param string $md5 code MD5
     *
     * @return array
     */
    private function setOptions(string $md5): array
    {
        $tabupload = [];

        $options['md5'] = $md5;
        if (!isset($this->params['upload'])) {
            $this->params['upload'] = [];
        }

        $tab = $this->setMinMax();

        if (0 !== count($tab)) {
            $options = array_merge($options, $tab);
        }

        $tab = [
            'image_versions' => [
                'thumbnail' => [
                    'max_width'  => 80,
                    'max_height' => 80,
                ],
                '' => [
                    'max_height' => 0,
                    'max_width'  => 0,
                ],
            ],
        ];
        foreach ($tabupload as $id => $val) {
            if (isset($tab['image_versions'][''][$id])) {
                $tab['image_versions'][''][$id] = $val;
            }
        }

        if (0 !== count($tab['image_versions'][''])) {
            $options = array_merge($options, $tab);
        }

        $urlsite = $this->request->getSchemeAndHttpHost() . $this->router->getContext()->getBaseUrl();
        if (isset($options['md5'])) {
            $route                    = $this->request->get('_route');
            $routeParams              = $this->request->attributes->get('_route_params');
            $options['script_url']    = $this->router->generate($route, $routeParams);
            $md5                      = $options['md5'];
            $filename                 = $this->request->server->get('SCRIPT_FILENAME');
            $emplacement              = dirname($filename);
            $options['upload_dir']    = $emplacement . '/tmp/' . $md5 . '/';
            $options['thumbnail_dir'] = $emplacement . '/tmp/' . $md5 . '/thumbnail/';
            $options['upload_url']    = $urlsite . '/tmp/' . $md5 . '/';
        }

        if (isset($options['upload_video'])) {
            unset($options['upload_video']);
            $options['accept_file_types'] = '/\.(MP4|mp4|MOV|mov|AVI|avi)$/i';
        }

        if (!isset($options['accept_file_types'])) {
            $options['accept_file_types'] = '/\.(JPG|jpg|JPEG|jpeg|PNG|png|PDF|pdf|ico|ICO)$/i';
        }

        return $options;
    }

    /**
     * Fixe les tailles.
     *
     * @return array
     */
    private function setMinMax(): array
    {
        $route = $this->request->attributes->get('_route');
        $tab   = [
            'min_height' => 0,
            'max_height' => 0,
            'min_width'  => 0,
            'max_width'  => 0,
        ];
        foreach ($this->params['upload'] as $tabupload) {
            foreach ($tabupload as $id => $val) {
                if (isset($tab[$id]) && $tabupload['url'] === $route) {
                    $tab[$id] = $val;
                }
            }
        }

        return $tab;
    }

    /**
     * Initialisation de l'upload quand c'est pas lié a un formulaire.
     *
     * @param string $md5      code unique
     * @param array  $fichiers tableau de fichiers
     *
     * @return void
     */
    private function initFolderUpload($md5, $fichiers): void
    {
        $filename    = $this->request->server->get('SCRIPT_FILENAME');
        $emplacement = dirname($filename);
        $finfo       = finfo_open(FILEINFO_MIME_TYPE);
        if (!is_dir($emplacement . '/tmp/' . $md5)) {
            mkdir($emplacement . '/tmp/' . $md5, 0775, TRUE);
        } else {
            if (is_dir($emplacement . '/tmp/' . $md5 . '/thumbnail')) {
                $oldfichiers = glob($emplacement . '/tmp/' . $md5 . '/thumbnail/*.*');
                foreach ($oldfichiers as $fichier) {
                    unlink($fichier);
                }
            }

            $oldfichiers = glob($emplacement . '/tmp/' . $md5 . '/*.*');
            foreach ($oldfichiers as $fichier) {
                unlink($fichier);
            }
        }

        foreach ($fichiers as $fichier) {
            if (is_file($fichier)) {
                $tab         = explode('/', $fichier);
                $depart      = $fichier;
                $destination = $emplacement . '/tmp/' . $md5 . '/' . $tab[count($tab) - 1];
                copy($depart, $destination);
                $depart = $fichier;
                if (0 !== substr_count(finfo_file($finfo, $depart), 'image')) {
                    $destination = $emplacement . '/tmp/' . $md5 . '/thumbnail/' . $tab[count($tab) - 1];
                    if (!is_dir($emplacement . '/tmp/' . $md5 . '/thumbnail')) {
                        mkdir($emplacement . '/tmp/' . $md5 . '/thumbnail', 0775, TRUE);
                    }

                    $this->imageResize($depart, $destination, 80, 80);
                }
            }
        }
    }

    /**
     * Crée les thumb des images a afficher au départ.
     *
     * @param mixed $src         source
     * @param mixed $dst         destination
     * @param int   $imageWidth  width
     * @param int   $imageHeight height
     *
     * @return void
     */
    private function imageResize($src, $dst, int $imageWidth, int $imageHeight): void
    {
        if (!list($imageW, $imageH) = getimagesize($src)) {
            return;
        }

        $type = strtolower(substr(strrchr($src, '.'), 1));
        if ('jpeg' === $type) {
            $type = 'jpg';
        }

        $img = $this->setImg($type, $src);

        if (is_string($img)) {
            return;
        }

        // resize
        if ($imageW < $imageWidth and $imageH < $imageHeight) {
            return;
        }

        $ratio       = min($imageWidth / $imageW, $imageHeight / $imageH);
        $imageWidth  = $imageW * $ratio;
        $imageHeight = $imageH * $ratio;
        $x           = 0;

        $new = imagecreatetruecolor($imageWidth, $imageHeight);

        // preserve transparency
        if ('gif' === $type or 'png' === $type) {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, FALSE);
            imagesavealpha($new, TRUE);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $imageWidth, $imageHeight, $imageW, $imageH);
        $this->generateNewImage($type, $new, $dst);
    }

    /**
     * Initalise la nouvelle image.
     *
     * @param string $type type d'image
     * @param mixed  $src  source
     *
     * @return mixed
     */
    private function setImg($type, $src)
    {
        $img = '';
        if ('bmp' === $type) {
            $img = imagecreatefromwbmp($src);
        }

        if ('gif' === $type) {
            $img = imagecreatefromgif($src);
        }

        if ('jpg' === $type) {
            $img = imagecreatefromjpeg($src);
        }

        if ('png' === $type) {
            $img = imagecreatefrompng($src);
        }

        return $img;
    }

    /**
     * Créer la nouvelle image.
     *
     *
     * @param string $type type d'image
     * @param mixed  $new  nouvelle image
     * @param mixed  $dst  destination
     *
     * @return void
     */
    private function generateNewImage($type, $new, $dst): void
    {
        if ('bmp' === $type) {
            imagewbmp($new, $dst);
        } elseif ('gif' === $type) {
            imagegif($new, $dst);
        } elseif ('jpg' === $type) {
            imagejpeg($new, $dst);
        } elseif ('png' === $type) {
            imagepng($new, $dst);
        }
    }
}
