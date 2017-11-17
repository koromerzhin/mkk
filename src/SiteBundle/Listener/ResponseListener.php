<?php

namespace Mkk\SiteBundle\Listener;

use Mkk\SiteBundle\Listener\Traits\ResponseTrait;
use Mkk\SiteBundle\Service\TelephoneService;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Routing\Router;

class ResponseListener
{
    use ResponseTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var array
     */
    protected $fichier;
    /**
     * @var TelephoneService
     */
    private $telephoneService;

    /**
     * @var TwigEngine
     */
    private $templating;

    /**
     * Init Listener.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container        = $container;
        $this->router           = $container->get('router');
        $this->telephoneService = $container->get(TelephoneService::class);
        $this->templating       = $container->get('templating');
    }

    /**
     * On Kernel Response.
     *
     * @param FilterResponseEvent $event FilterResponseEvent
     *
     * @return void
     */
    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $this->setTwigTemplates();
        $request                   = $event->getRequest();
        $route                     = $request->get('_route');
        $response                  = $event->getResponse();
        $content                   = $response->getContent();
        $this->template['Tel']     = $this->fichier['Tel'];
        $this->template['Country'] = $this->fichier['Country'];
        $this->template['Email']   = $this->fichier['Email'];
        if (0 !== substr_count($route, 'admin.')) {
            $template['Tel']     = $this->fichier['AdminTel'];
            $template['Country'] = $this->fichier['AdminCountry'];
            $template['Email']   = $this->fichier['AdminEmail'];
        } else {
            $content = $this->modifVideo($content);
            $content = $this->modifGalerie($content, $this->fichier['Diaporama']);
        }

        $content = $this->modifierBoolean($content);
        $content = $this->modifierDay($content, $request->getLocale());
        $content = $this->modifierTemps($content, $request->getLocale());
        $content = $this->modifierHeure($content, $request->getLocale());
        $content = $this->modifTelephone($content, $request->getLocale(), $this->template['Tel']);
        $content = $this->modifCountry($content, $request->getLocale(), $this->template['Country']);
        $content = $this->modifEmail($content, $this->template['Email']);
        $content = $this->modifForm($content);
        $content = $this->addUploadFormTmpl($content);
        $content = $this->addModal($content);
        $content = $this->imgLazyLoad($content);
        $content = $this->obclean($content);
        $response->setContent($content);
        $event->setResponse($response);
    }
}
