<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ParamService
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var TableService
     */
    protected $paramManager;

    /**
     * @var array
     */
    protected $paramlisting;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $requestStack       = $container->get('request_stack');
        $this->paramManager = $container->get('bdd.param_manager');
        $this->request      = $requestStack->getCurrentRequest();
    }

    /**
     * Liste des paramètres.
     *
     * @return array
     */
    public function listing(): array
    {
        $paramRepository = $this->paramManager->getRepository();
        if (isset($this->paramlisting)) {
            return $this->paramlisting;
        }

        $params = $paramRepository->findall();
        foreach ($params as $param) {
            $code        = $param->getCode();
            $data[$code] = $param->getValeur();
        }

        $this->paramManager->flush();

        foreach ($data as $key => $value) {
            if ($this->isJson($value)) {
                $data[$key] = json_decode($value, TRUE);
            } elseif (0 === substr_count($key, '-min_') && 0 === substr_count($key, '-max_')) {
                $data[$key] = $value;
            }
        }

        $this->paramlisting = $data;

        return $this->paramlisting;
    }

    /**
     * Creer le code de configuration pour hybridauth.
     *
     * @param array  $param Parametre du site
     * @param string $url   Url du site Internet
     * @param array  $data  Configuration des providers
     *
     * @return array
     */
    public function social($param, $url, $data): array
    {
        $param       = $this->listing();
        $paramsocial = [];
        $tab         = explode(',', 'yahoo,google,facebook,twitter,live,linkedin,foursquare');
        foreach ($tab as $code) {
            if (isset($param[$code . '_key'])) {
                $paramsocial[$code . '_key'] = $param[$code . '_key'];
            } else {
                $paramsocial[$code . '_key'] = '';
            }

            if (isset($param[$code . '_secret'])) {
                $paramsocial[$code . '_secret'] = $param[$code . '_secret'];
            } else {
                $paramsocial[$code . '_secret'] = '';
            }
        }

        $config = [
            'base_url'  => $url,
            'providers' => [
                // openid providers
                'OpenID' => [
                    'enabled' => TRUE,
                ],
                'Yahoo' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'key'    => $paramsocial['yahoo_key'],
                        'secret' => $paramsocial['yahoo_secret'],
                    ],
                ],
                'AOL' => [
                    'enabled' => TRUE,
                ],
                'Google' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'id'     => $paramsocial['google_key'],
                        'secret' => $paramsocial['google_secret'],
                    ],
                ],
                'Facebook' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'id'     => $paramsocial['facebook_key'],
                        'secret' => $paramsocial['facebook_secret'],
                    ],
                    'trustForwarded' => FALSE,
                ],
                'Twitter' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'key'    => $paramsocial['twitter_key'],
                        'secret' => $paramsocial['twitter_secret'],
                    ],
                    'trustForwarded' => FALSE,
                ],
                'Live' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'id'     => $paramsocial['live_key'],
                        'secret' => $paramsocial['live_secret'],
                    ],
                ],
                'LinkedIn' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'key'    => $paramsocial['linkedin_key'],
                        'secret' => $paramsocial['linkedin_secret'],
                    ],
                ],
                'Foursquare' => [
                    'enabled' => TRUE,
                    'keys'    => [
                        'id'     => $paramsocial['foursquare_key'],
                        'secret' => $paramsocial['foursquare_secret'],
                    ],
                ],
            ],
            // If you want to enable logging, set 'debug_mode' to true.
            // You can also set it to
            // - "error" To log only error messages. Useful in production
            // - "info" To log info and error messages (ignore debug messages)
            'debug_mode' => FALSE,
            // Path to file writable by the web server. Required if 'debug_mode' is not false
            'debug_file' => '',
        ];
        foreach ($data as $code => $tab) {
            $config['providers'][$code] = array_merge($config['providers'][$code], $data[$code]);
        }

        return $config;
    }

    /**
     * Sauvegarde un nouveau paramétre.
     *
     * @param string $key code Clef à supprimer de la
     *                    BDD
     *
     * @return void
     */
    public function delete($key): void
    {
        $paramRepository = $this->paramManager->getRepository();
        $entity          = $paramRepository->findOneByCode($key);
        if ($entity) {
            $this->paramManager->remove($entity);
            $this->paramManager->flush();
        }
    }

    /**
     * Sauvegarde un nouveau paramétre.
     *
     * @param string $key    code
     * @param string $valeur chaine de caractères
     *
     * @return void
     */
    public function save($key, $valeur): void
    {
        $paramRepository = $this->paramManager->getRepository();
        $paramEntity     = $this->paramManager->getTable();
        $entity          = $paramRepository->findOneByCode($key);
        if (!$entity) {
            $entity = new $paramEntity();
            $entity->setCode($key);
        }

        if (is_array($valeur)) {
            $valeur = json_encode($valeur, JSON_FORCE_OBJECT);
        }

        $entity->setValeur($valeur);
        $this->paramManager->persistandFlush($entity);
    }

    /**
     * Si la chaine est un array ou pas.
     *
     * @param mixed $string verifie si la chaine est un json
     *
     * @return bool
     */
    private function isJson($string): bool
    {
        $return = ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? TRUE : FALSE;

        return $return;
    }
}
