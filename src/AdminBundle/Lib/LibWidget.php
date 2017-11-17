<?php

namespace Mkk\AdminBundle\Lib;

use Mkk\SiteBundle\Service\ParamService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class LibWidget
{
    protected $titre;
    protected $list;
    protected $table;
    protected $manager;
    protected $templating;

    /**
     * @var ContainerInterface
     */
    protected $container;
    private $token;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    /**
     * Init.
     *
     * @param ContainerInterface $container DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->templating   = $container->get('templating');
        $this->paramService = $container->get(ParamService::class);
        $this->requestStack = $container->get('request_stack');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->token        = $container->get('security.token_storage')->getToken();
    }

    /**
     * Génére le html.
     *
     * @return array
     */
    public function html(): array
    {
        $repository = $this->manager->getRepository();
        $url        = isset($this->url) ? $this->url : [];
        $param      = [
            'url'   => $url,
            'titre' => $this->titre,
        ];

        $html                    = '';
        $return                  = [];
        $params                  = isset($this->params) ? $this->params : [];
        $params                  = array_merge($params, $this->request->query->all());
        $params['user']          = $this->token->getUser();
        $params['params_config'] = $this->paramService->listing();
        if (isset($this->list)) {
            $html            = 'list';
            $param['total']  = $repository->totalWidgetList($params);
            $param['search'] = $repository->searchWidgetList($params);
            $param['table']  = $this->table;

            $html = $this->templating->render(
                "MkkAdminBundle:Widget:{$html}.html.twig",
                $param
            );

            $return = [$html];
        } elseif (isset($this->info)) {
            $html = 'info';
            $html = $this->templating->render(
                "MkkAdminBundle:Widget:{$html}.html.twig",
                $param
            );

            $return = [$html];
        }

        return $return;
    }
}
