<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Handler\UploadHandler;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FormService
{
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var Request
     */
    protected $request;

    protected $forms;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var bool
     */
    protected $redirect;

    /**
     * @var AnnotationReaderService
     */
    protected $annotationReader;

    /**
     * @var ParamService
     */
    protected $paramService;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $etat;

    protected $manager;

    /**
     * @var array
     */
    protected $params;
    /**
     * @var UploadHandler
     */
    private $handler;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container        = $container;
        $this->annotationReader = $container->get(AnnotationReaderService::class);
        $this->paramService     = $container->get(ParamService::class);
        $this->params           = $this->paramService->listing();
        $this->requestStack     = $container->get('request_stack');
        $this->request          = $this->requestStack->getCurrentRequest();
        $this->formFactory      = $container->get('form.factory');
        $this->handler          = $container->get(UploadHandler::class);
        $this->redirect         = FALSE;
    }

    /**
     * Verifie s'il faut rediriger.
     *
     * @return bool
     */
    public function isRedirect(): bool
    {
        return $this->redirect;
    }

    /**
     * Set etat.
     *
     * @param string $etat ajouter / modifier
     *
     * @return void
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }

    /**
     * Set manager.
     *
     * @param TableService $manager ajouter / modifier
     *
     * @return void
     */
    public function setManager(?TableService $manager = NULL): void
    {
        $this->manager = $manager;
    }

    /**
     * Initalisation des formulaires.
     *
     * @param string $service FormType.php ou admin.competence.form
     * @param mixed  $entity  Mkk\SiteBundle\Entity\Blog par exemple
     * @param array  $options options pour le formulaie (A
     *                        déconseillé)
     *
     * @return void
     */
    public function set($service, $entity = NULL, array $options = []): void
    {
        $request  = $this->request;
        $data     = $this->setForm($service);
        $flashbag = $request->getSession()->getFlashBag();
        if (NULL !== $entity) {
            $methods          = get_class_methods($entity);
            $uploadableFields = $this->annotationReader->getUploadableFields($entity);
            if (!in_array('setUpdatedAt', $methods) && 0 !== count($uploadableFields)) {
                $message = 'Il manque un champs updatedAt dans ';
                $message = $message . substr(get_class($entity), strpos(get_class($entity), 'Entity'));
                $flashbag->add('warning', $message);
                $this->redirect = TRUE;

                return;
            }

            foreach ($uploadableFields as $property => $annotation) {
                $this->handler->setFileFromFilename($entity, $property, $annotation);
            }
        }

        if (0 === count($data)) {
            $flashbag->add('danger', 'Aucun formulaire existe avec le service ' . $service);
            $this->redirect = TRUE;

            return;
        }

        if (1 === count($data)) {
            $this->creaForm($data, $entity, $options);

            return;
        }

        $forms = [];
        if (!isset($this->params['languesite']) || !isset($this->params['langueprincipal'])) {
            $flashbag->add('warning', 'Aucune langue est configuré dans les paramètres');
            $this->redirect = TRUE;

            return;
        }

        $this->creationForms($data, $options, $service, $methods, $entity, $forms);
    }

    /**
     * Donne les formulaires.
     *
     * @return mixed
     */
    public function get()
    {
        return $this->forms;
    }

    /**
     * Retourne les formulaire visible pour twig.
     *
     * @return mixed
     */
    public function views()
    {
        $forms = $this->forms;
        if (is_object($forms)) {
            $return = $forms->createView();

            return $return;
        }

        if (is_array($forms)) {
            foreach ($forms as $id => $form) {
                $forms[$id] = $form->createView();
            }
        }

        return $forms;
    }

    /**
     * Création du formulaire.
     *
     * @param array $data    formulaire
     * @param mixed $entity  Entité
     * @param array $options options pour le formulaire
     *
     * @return void
     */
    private function creaForm($data, $entity, $options): void
    {
        if (0 !== substr_count($data[0], "\Form")) {
            $formService = $data[0];
        } else {
            $formService = $this->container->get($data[0]);
        }

        $form = $this->formFactory->create(
            $formService,
            $entity,
            $options
        );

        $this->forms = $form;
    }

    /**
     * Quel formulaires ?.
     *
     * @param mixed $service Service
     *
     * @return array
     */
    private function setForm($service): array
    {
        $servicesID = $this->container->getServiceIds();
        $data       = [];
        if (0 !== substr_count($service, "\Form")) {
            $data[0] = $service;
        } else {
            foreach ($servicesID as $code) {
                if (0 !== substr_count($code, $service)) {
                    $data[] = $code;
                }
            }
        }

        return $data;
    }

    /**
     * Partie de création des formulaires.
     *
     * @param array  $data    data
     * @param array  $options options pour le formulaire
     * @param string $service string
     * @param array  $methods string
     * @param mixed  $entity  entity
     * @param mixed  $forms   formulaire(s)
     *
     * @return void
     */
    private function creationForms($data, $options, $service, $methods, $entity, $forms): void
    {
        $newforms = [];
        foreach ($data as $code) {
            $type = str_replace($service . '.', '', $code);
            if ('standard' === $type) {
                $formService     = $this->container->get($code);
                $newforms[$type] = $this->formFactory->create(
                    get_class($formService),
                    $entity,
                    $options
                );
            } else {
                $formService     = $this->container->get($code);
                $langueprincipal = $this->params['langueprincipal'];
                foreach ($this->params['languesite'] as $locale) {
                    $test1 = $langueprincipal !== $locale;
                    $test2 = 'modifier' === $this->etat;
                    $test3 = in_array('setTranslatableLocale', $methods);
                    if ($test1 && $test2 && $test3) {
                          $entity->setTranslatableLocale($locale);
                          $this->manager->refresh($entity);
                    }

                      $form = $this->formFactory->createNamedBuilder(
                          'langue' . $locale,
                          get_class($formService),
                          $entity
                      );

                      $forms['langue' . $locale] = $form->getForm();
                }

                if ('modifier' === $this->etat) {
                    $entity->setTranslatableLocale($this->container->get('translator')->getLocale());
                    $this->manager->refresh($entity);
                }
            }
        }

        foreach ($forms as $code => $form) {
            $newforms[$code] = $form;
        }

        $this->forms = $newforms;
    }
}
