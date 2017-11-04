<?php

namespace Mkk\SiteBundle\Service;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class TelephoneService
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
     * @var Router
     */
    protected $router;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $requestStack    = $container->get('request_stack');
        $this->router    = $container->get('router');
        $this->request   = $requestStack->getCurrentRequest();
    }

    /**
     * Verifie le numéro de téléphone en fonction du pays.
     *
     * @param string $numero Numéro de téléphone
     * @param string $locale code du pays
     *
     * @return array
     */
    public function verif(string $numero, string $locale): array
    {
        $generateurl = 'site.index';
        $numero      = str_replace([' ', '-', '.'], '', $numero);
        try {
            $phoneUtil             = PhoneNumberUtil::getInstance();
            $numberProto           = $phoneUtil->parseAndKeepRawInput($numero, strtoupper($locale));
            $json['country']       = $phoneUtil->getRegionCodeForNumber($numberProto);
            $json['international'] = '+' . $numberProto->getNationalNumber();
            $json['num']           = $numberProto->getCountryCodeSource() . $numberProto->getNationalNumber();
        } catch (NumberParseException $e) {
            $json['error'] = $e->__toString();
        }

        if (isset($json['country']) && '' !== $json['country']) {
            $json['iconpays'] = $this->router->generate($generateurl, [], TRUE);
            $json['iconpays'] = $json['iconpays'] . 'bundles/mkksite/img/country/' . $json['country'] . '.png';
        }

        return $json;
    }
}
