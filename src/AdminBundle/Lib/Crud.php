<?php

namespace Mkk\AdminBundle\Lib;

use Mkk\AdminBundle\Lib\Controller\Crud\CrudBoolean;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudDelete;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudEmpty;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudExport;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudForm;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudList;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudPosition;
use Mkk\AdminBundle\Lib\Controller\Crud\CrudShow;
use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Crud
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LibController
     */
    private $controller;

    /**
     * @var CrudBoolean
     */
    private $boolean;

    /**
     * @var CrudDelete
     */
    private $delete;

    /**
     * @var CrudEmpty
     */
    private $empty;

    /**
     * @var CrudForm
     */
    private $form;

    /**
     * @var CrudList
     */
    private $list;

    /**
     * @var CrudExport
     */
    private $export;

    /**
     * @var CrudPosition
     */
    private $position;

    /**
     * @var TableService
     */
    private $manager;

    /**
     * Init.
     *
     * @param ContainerInterface $container DI
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->boolean   = $container->get(CrudBoolean::class);
        $this->delete    = $container->get(CrudDelete::class);
        $this->empty     = $container->get(CrudEmpty::class);
        $this->form      = $container->get(CrudForm::class);
        $this->show      = $container->get(CrudShow::class);
        $this->list      = $container->get(CrudList::class);
        $this->export    = $container->get(CrudExport::class);
        $this->position  = $container->get(CrudPosition::class);
    }

    /**
     * getBoolean.
     *
     * @return CrudBoolean
     */
    public function getBoolean(): CrudBoolean
    {
        $return = $this->initReturn($this->boolean);

        return $return;
    }

    /**
     * getDelete.
     *
     * @return CrudDelete
     */
    public function getDelete(): CrudDelete
    {
        $return = $this->initReturn($this->delete);

        return $return;
    }

    /**
     * getEmpty.
     *
     * @return CrudEmpty
     */
    public function getEmpty(): CrudEmpty
    {
        $return = $this->initReturn($this->empty);

        return $return;
    }

    /**
     * getForm.
     *
     * @return CrudShow
     */
    public function getShow(): CrudShow
    {
        $return = $this->initReturn($this->show);

        return $return;
    }

    /**
     * getForm.
     *
     * @return CrudForm
     */
    public function getForm(): CrudForm
    {
        $return = $this->initReturn($this->form);

        return $return;
    }

    /**
     * getList.
     *
     * @return CrudExport
     */
    public function getExport(): CrudExport
    {
        $return = $this->initReturn($this->export);

        return $return;
    }

    /**
     * getList.
     *
     * @return CrudList
     */
    public function getList(): CrudList
    {
        $return = $this->initReturn($this->list);

        return $return;
    }

    /**
     * getPosition.
     *
     * @return CrudPosition
     */
    public function getPosition(): CrudPosition
    {
        $return = $this->initReturn($this->position);

        return $return;
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
        $this->manager = $manager;
    }

    /**
     * Set le controller.
     *
     * @param LibController $controller classe par défaut
     *
     * @return void
     */
    public function setController(LibController $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Pour initialiser le retour crud.
     *
     * @param mixed $return CrudBoolean | CrudDelete | CrudEmpty | CrudForm | CrudList | CrudPosition
     *
     * @return mixed
     */
    private function initReturn($return)
    {
        $return->setController($this->controller);
        $return->setManager($this->manager);

        return $return;
    }
}
