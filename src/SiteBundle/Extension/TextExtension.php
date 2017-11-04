<?php

namespace Mkk\SiteBundle\Extension;

use Mkk\SiteBundle\Lib\LibTextExtension;
use Twig_SimpleFilter;

class TextExtension extends LibTextExtension
{
    /**
     * indique les filtres disponibles.
     *
     * @return array
     */
    public function getFilters(): array
    {
        $return = [
            new Twig_SimpleFilter('isCurrentRoute', [$this, 'isCurrentRoute']),
            new Twig_SimpleFilter('language', [$this, 'language']),
            new Twig_SimpleFilter('isObject', [$this, 'isObject']),
            new Twig_SimpleFilter('isArray', [$this, 'isArray']),
            new Twig_SimpleFilter('isInt', [$this, 'isInt']),
            new Twig_SimpleFilter('isFloat', [$this, 'isFloat']),
            new Twig_SimpleFilter('isNumeric', [$this, 'isNumeric']),
            new Twig_SimpleFilter('isBool', [$this, 'isBool']),
            new Twig_SimpleFilter('jsonDecode', [$this, 'jsonDecode']),
            new Twig_SimpleFilter('jsonEncode', [$this, 'jsonEncode']),
            new Twig_SimpleFilter('get', [$this, 'get']),
            new Twig_SimpleFilter('isFile', [$this, 'isFile']),
            new Twig_SimpleFilter('attributeHtml', [$this, 'attributeHtml']),
        ];

        return $return;
    }

    /**
     * Savoir si la route est courante.
     *
     * @param string $menu code de la route
     *
     * @return bool
     */
    public function isCurrentRoute($menu): bool
    {
        $return = FALSE;
        $route  = $this->request->attributes->get('_route');
        if (isset($menu['sousmenu'])) {
            foreach ($menu['sousmenu'] as $menu) {
                if (isset($menu['url']) && $menu['url'] === $route) {
                    $return = TRUE;
                }
            }
        } else {
            if (isset($menu['url']) && $menu['url'] === $route) {
                $return = TRUE;
            }
        }

        return $return;
    }

    /**
     * Donne le nom de la langue.
     *
     * @param string $langue code de la langue
     *
     * @return string
     */
    public function language($langue): string
    {
        $text         = $langue;
        $locale       = $this->request->getLocale();
        $languageName = $this->languageBundle->getLanguageNames($locale);
        if (isset($languageName[$langue])) {
            $text = ucfirst($languageName[$langue]);
        }

        return $text;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isObject($var): bool
    {
        $return = is_object($var);

        return $return;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isInt($var): bool
    {
        $return = is_int($var);

        return $return;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isFloat($var): bool
    {
        $return = is_float($var);

        return $return;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isArray($var): bool
    {
        $return = is_array($var);

        return $return;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isNumeric($var): bool
    {
        $return = is_numeric($var);

        return $return;
    }

    /**
     * Verifie le type du champs.
     *
     * @param mixed $var Champs
     *
     * @return bool
     */
    public function isBool($var): bool
    {
        $return = is_bool($var);

        return $return;
    }

    /**
     * Affiche les données d'un row.
     *
     * @param mixed  $row Entité
     * @param string $id  Clef
     *
     * @return mixed
     */
    public function get($row, $id)
    {
        $methods = get_class_methods($row);
        $id      = ucfirst($id);
        $return  = "get{$id}";
        if (in_array("get{$id}", $methods, TRUE)) {
            $return = call_user_func([$row, "get{$id}"]);
        } elseif (in_array("is{$id}", $methods, TRUE)) {
            $return = call_user_func([$row, "is{$id}"]);
        }

        return $return;
    }

    /**
     * Indique si le fichier existe.
     *
     * @param string $file Fichier
     *
     * @return bool
     */
    public function isFile($file): bool
    {
        $folder = '';
        if (is_dir('web')) {
            $folder = 'web/';
        }

        $isfile = is_file($folder . $file);

        return $isfile;
    }

    /**
     * Ajoute des attributs.
     *
     * @param array $tab tableau des attributs
     *
     * @return string
     */
    public function attributeHtml(array $tab): STRING
    {
        $html = '';
        foreach ($tab as $code => $val) {
            $html = $html . $code . '="' . $val . '"';
        }

        return $html;
    }

    /**
     * transforme le tableau en json.
     *
     * @param array $tab data
     *
     * @return string
     */
    public function jsonEncode(array $tab): string
    {
        $return = json_encode($tab, TRUE);

        return $return;
    }

    /**
     * transforme le text en jtableau.
     *
     * @param string $tab data
     *
     * @return array
     *
     * @author
     * @copyright
     */
    public function jsonDecode(string $tab): array
    {
        $return = json_decode($tab);

        return $return;
    }
}
