<?php

namespace Mkk\AdminBundle\Lib\Controller\Crud;

use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Lib\LibRepository;
use Mkk\SiteBundle\Service\ParamService;
use Mkk\SiteBundle\Table\TableService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class CrudExport
{
    protected $templating;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $show;

    /**
     * @var LibRepository
     */
    private $repository;

    /**
     * @var TableService
     */
    private $manager;

    /**
     * @var LibController
     */
    private $controller;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Router
     */
    private $router;

    /**
     *  @var FlashBag
     */
    private $flashBag;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var ParamService
     */
    private $paramService;

    private $token;

    /**
     * Init controller.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->requestStack = $container->get('request_stack');
        $this->router       = $container->get('router');
        $this->request      = $this->requestStack->getCurrentRequest();
        $this->paramService = $container->get(ParamService::class);
        $this->session      = $this->request->getSession();
        $this->token        = $container->get('security.token_storage')->getToken();
        $this->flashBag     = $this->session->getFlashBag();
        $this->templating   = $container->get('templating');
        $this->show         = [];
    }

    /**
     * Set le controller.
     *
     * @param Controller $controller classe par défaut
     *
     * @return void
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Rendu pour vider une table.
     *
     * @param array $params paramètres
     *
     * @return Response
     */
    public function render($params = []): Response
    {
        $spreadsheet             = new Spreadsheet();
        $sheet                   = $spreadsheet->getActiveSheet();
        $params                  = array_merge($params, $this->request->query->all());
        $params['user']          = $this->token->getUser();
        $params['params_config'] = $this->paramService->listing();
        $query                   = call_user_func_array([$this->repository, 'searchAdminList'], [$params]);
        $iter                    = 1;
        foreach ($this->show as $row) {
            $sheet->setCellValueByColumnAndRow($iter, 1, $row['label']);
            ++$iter;
        }

        $result = $query->getArrayResult();
        foreach ($result as $row) {
            $iterCol = 1;
            foreach ($this->show as $col) {
                $html = $this->templating->render(
                    'MkkAdminBundle:Crud:export.html.twig',
                    [
                    'a'   => $col,
                    'row' => $row,
                    ]
                );
                $html = trim($html);
                $sheet->setCellValueByColumnAndRow($iterCol, $iter - 1, $html);
                ++$iterCol;
            }

            ++$iter;
        }

        $md5    = md5(uniqid());
        $file   = "tmp/{$md5}.xlsx";
        $writer = new Xlsx($spreadsheet);
        $writer->save($file);
        $url      = $this->router->generate('site.index');
        $redirect = new RedirectResponse("{$url}/{$file}");

        return $redirect;
    }

    /**
     * Indique le manager.
     *
     * @param TableService $manager pour savoir quel table utiliser
     *
     * @return void
     */
    public function setManager(TableService $manager): void
    {
        $this->manager    = $manager;
        $this->repository = $this->manager->getRepository();
    }

    /**
     * Ajoute un champs pour la table.
     *
     * @param string $nom  nom
     * @param array  $data data
     *
     * @return self
     */
    public function addShow($nom, $data = []): self
    {
        $new = array_merge(
            [
              'col'  => $nom,
              'id'   => FALSE,
              'sort' => FALSE,
            ],
            $data
        );

        if (!isset($new['label'])) {
            $new['label'] = $nom;
        }

        $this->show[$nom] = $new;

        return $this;
    }
}
