<?php

namespace Mkk\AdminBundle\Controller;

use Mkk\AdminBundle\Lib\LibController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends LibController
{
    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->setTitre('Dashboard');
    }

    /**
     * @Route("/", name="admin.index")
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        $widgets    = [];
        $servicesID = $this->container->getServiceIds();
        foreach ($servicesID as $service) {
            if (0 !== substr_count($service, "AdminBundle\Widget")) {
                $widget = $this->container->get($service);
                $widget->init();
                $widgets = array_merge($widgets, $widget->html());
            }
        }

        $render = $this->render(
            'MkkAdminBundle:Dashboard:index.html.twig',
            [
                'widgets' => $widgets,
            ]
        );

        return $render;
    }
}
