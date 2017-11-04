<?php

namespace Mkk\SiteBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class GeocodeService
{
    /**
     * @var Request
     */
    protected $request;

    protected $controller;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $params          = $container->get(ParamService::class);
        $this->params    = $params->listing();
        $requestStack    = $container->get('request_stack');
        $this->request   = $requestStack->getCurrentRequest();
    }

    /**
     * Récupére les info sur la région.
     *
     * @param int $id id de la
     *                région
     *
     * @return array
     */
    public function getRegion($id): array
    {
        $url = 'http://api.geonames.org/childrenJSON?geonameId=' . $id;
        $md5 = md5($url);
        if (!is_file('tmp/geonames/' . $md5)) {
            if (isset($this->params['geonames']) && '' !== $this->params['geonames']) {
                $url = $url . '&username=' . $this->params['geonames'];
            }

            $contents = file_get_contents($url);
            file_put_contents('tmp/geonames/' . $md5, $contents);
        }

        $contents = file_get_contents('tmp/geonames/' . $md5);
        $tab      = json_decode($contents, TRUE);
        if (0 === count($tab)) {
            unlink('tmp/geonames/' . $md5);
        }

        return $tab['geonames'];
    }

    /**
     * Récupére les info sur la ville.
     *
     * @param int $id id geonames
     *
     * @return array
     */
    public function getInfoGeoname($id): array
    {
        $url = 'http://api.geonames.org/getJSON?geonameId=' . $id;
        $md5 = md5($url);
        if (!is_file('tmp/geonames/' . $md5)) {
            if (isset($this->params['geonames']) && '' !== $this->params['geonames']) {
                $url = $url . '&username=' . $this->params['geonames'];
            }

            $contents = file_get_contents($url);
            file_put_contents('tmp/geonames/' . $md5, $contents);
        }

        $contents = file_get_contents('tmp/geonames/' . $md5);
        $tab      = json_decode($contents, TRUE);
        if (0 === count($tab)) {
            unlink('tmp/geonames/' . $md5);
        }

        return $tab;
    }

    /**
     * Récupére les info sur la ville.
     *
     * @return void
     */
    public function getcpville(): array
    {
        $response   = [];
        $codePostal = $this->request->get('cp');
        $ville      = $this->request->get('ville');
        $gps        = $this->request->get('gps');
        $url        = $this->setURl();
        if ('' === $url) {
            return $response;
        }

        $url = 'http://api.geonames.org/' . $url;
        $md5 = md5($url);
        if (!is_dir('tmp/geonames/')) {
            mkdir('tmp/geonames');
        }

        if (!is_file('tmp/geonames/' . $md5)) {
            $contents = $this->getfileContent($url);
            file_put_contents('tmp/geonames/' . $md5, $contents);
        }

        $contents = file_get_contents('tmp/geonames/' . $md5);
        $tab      = json_decode($contents, TRUE);
        if (0 === count($tab)) {
            unlink('tmp/geonames/' . $md5);
            $response   = [];
            $response[] = [
                    'postalCode' => $codePostal,
                    'placeName'  => '',
                ];
        }

        if (isset($tab['postalCodes'])) {
            $response = $this->traiterPostalCodes($tab, $codePostal, $ville, $gps);
        } elseif (isset($tab['geonames'])) {
            $response = $tab['geonames'];
        } else {
            $response = $tab;
        }

        if (isset($response['status']['message']) && is_file('tmp/geonames/' . $md5)) {
            unlink('tmp/geonames/' . $md5);
        }

        $response = $this->responsePostalCode($response);

        return $response;
    }

    /**
     * Correction response.
     *
     * @param array $response data
     *
     * @return array
     */
    private function responsePostalCode($response): array
    {
        foreach ($response as $code => $val) {
            if (isset($val['postalCode'])) {
                $response[$code]['id'] = $val['postalCode'];
            }
        }

        return $response;
    }

    /**
     * Initialize l'url en fonction des paramètres envoyé en POST.
     *
     * @return string
     */
    private function setURl(): string
    {
        $pays       = $this->request->get('pays');
        $codePostal = $this->request->get('cp');
        $ville      = $this->request->get('ville');
        $url        = '';
        if ('' !== $codePostal) {
            $url = 'postalCodeSearchJSON?country=' . $pays . '&postalcode=' . urlencode($codePostal);
        } elseif ('' !== $ville) {
            $url = 'searchJSON?&name_startsWith=' . urlencode($ville) . '&country=';
            $url = $url . $pays . '&style=FULL&featureClass=A&featureCode=ADM4';
        }

        return $url;
    }

    /**
     * Récupére le content de Géonames.
     *
     * @param string $url Url
     *
     * @return string
     */
    private function getfileContent(string $url): string
    {
        if (isset($this->params['geonames']) && '' !== $this->params['geonames']) {
            $url = $url . '&username=' . $this->params['geonames'];
        }

        $content = file_get_contents($url);

        return $content;
    }

    /**
     * Traitement de geonames.
     *
     * @param array  $tab        data provenant de
     *                           Géonames
     * @param string $codePostal input code postal
     * @param string $ville      input ville
     * @param string $gps        input gps
     *
     * @return array
     */
    private function traiterPostalCodes(array $tab, string $codePostal, string $ville, string $gps): array
    {
        $response = $tab['postalCodes'];
        if ('' !== $ville) {
            $tab      = $response;
            $response = [];
            foreach ($tab as $data) {
                if (mb_strtoupper($ville, 'UTF-8') === mb_strtoupper($data['placeName'], 'UTF-8')) {
                    if ('' !== $gps) {
                        list($data['lat'], $data['lng']) = explode(',', $gps);
                    }

                    $response[] = $data;
                }
            }
        }

        if (0 === count($response)) {
            $response[] = [
                    'postalCode' => $codePostal,
                    'placeName'  => '',
                ];
        }

        return $response;
    }
}
