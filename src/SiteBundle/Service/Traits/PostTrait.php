<?php

namespace Mkk\SiteBundle\Service\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Mkk\SiteBundle\Table\TableService;
use Symfony\Component\Form\Form;

trait PostTrait
{
    /**
     * @var TableService
     */
    private $manager;

    /**
     * @var bool
     */
    private $success;

    /**
     * Initalisation référence.
     *
     * @return void
     */
    private function initReference(): void
    {
        $entity    = $this->entity;
        $originals = [];
        $methods   = get_class_methods($entity);
        if (is_array($methods)) {
            foreach ($methods as $method) {
                if (0 !== substr_count($method, 'get') && is_object($entity->$method())) {
                    $data      = $entity->$method();
                    $code      = str_replace('get', '', $method);
                    $fonctions = get_class_methods($data);
                    if (in_array('contains', $fonctions)) {
                        $originals[$code] = new ArrayCollection();
                        foreach ($entity->$method() as $data) {
                            $originals[$code]->add($data);
                        }
                    }
                }
            }
        }

        $this->reference = $originals;
    }

    /**
     * Supprimer la référence.
     *
     * @return void
     */
    private function delReference(): void
    {
        $entityManager = $this->container->get('bdd.menu_manager');
        $entity        = $this->entity;
        foreach ($this->reference as $id => $originals) {
            $fonction = 'get' . ucfirst($id);
            foreach ($originals as $row) {
                if (!$entity->$fonction()->contains($row)) {
                    $entityManager->remove($row);
                }
            }
        }

        $entityManager->flush();
    }

    /**
     * Set la génération a partir d'un select2.
     *
     * @param string $name champs a modifier
     *
     * @return void
     */
    private function setRef($name): void
    {
        $entity  = $this->entity;
        $methods = get_class_methods($entity);
        foreach ($methods as $method) {
            if ('getTab' === substr($method, 0, 6)) {
                $this->setTabEntity($name, $entity, $method);
            } elseif ('getRef' === substr($method, 0, 6)) {
                $this->setEntity($name, $entity, $method);
            }
        }
    }

    /**
     * Description of what this does.
     *
     * Set la table pour les childs
     *
     * @param string $name   champs envoyer en post
     * @param mixed  $entity Classe de la table a modifier
     * @param string $method methode
     *                       à
     *                       utiliser
     *
     * @return void
     */
    private function setTabEntity($name, $entity, $method): void
    {
        $methodGet       = str_replace('getTab', 'get', $method);
        $referenceAdd    = get_class($entity);
        $referenceAdd    = strtolower(substr($referenceAdd, strrpos($referenceAdd, '\\') + 1));
        $referenceAdd    = 'add' . ucfirst($referenceAdd);
        $referenceRemove = get_class($entity);
        $referenceRemove = strtolower(substr($referenceRemove, strrpos($referenceRemove, '\\') + 1));
        $referenceRemove = 'remove' . ucfirst($referenceRemove);
        $methodRemove    = substr(str_replace('getTab', 'remove', $method), 0, -1);
        $methodAdd       = substr(str_replace('getTab', 'add', $method), 0, -1);
        $champs          = strtolower(str_replace('get', '', $method));
        $request         = $this->request;
        $post            = $request->request->get($name);
        $newEntity       = strtolower(str_replace('getTab', '', $method));
        if ('s' === substr($newEntity, -1)) {
            $newEntity = substr($newEntity, 0, -1);
        }

        if (!isset($post[$champs]) || !$this->container->has('bdd.' . $newEntity . '_manager')) {
            return;
        }

        $this->manager = $this->container->get('bdd.' . $newEntity . '_manager');
        $repository    = $this->manager->getRepository();
        $val           = $post[$champs];
        $list          = explode(',', $val);
        if (0 === count($val)) {
            $this->supprimer($entity, $methodGet, $methodRemove);
        } else {
            foreach ($list as $id) {
                $data = $repository->find($id);
                if ($data && !$entity->$methodGet()->contains($data)) {
                    $entity->$methodAdd($data);
                    $data->$referenceAdd($entity);
                    $this->manager->persist($data);
                    $this->manager->persist($entity);
                }
            }
        }

        $this->supprimerNonPresent($entity, $methodGet, $methodRemove, $referenceRemove, $list);

        $this->manager->flush();
    }

    /**
     * Supprimer liaison non présent.
     *
     * @param mixed  $entity          entity
     * @param string $methodGet       method
     * @param string $methodRemove    method
     * @param string $referenceRemove reference remove
     * @param array  $list            reference present
     *
     * @return void
     */
    private function supprimerNonPresent($entity, string $methodGet, string $methodRemove, string $referenceRemove, array $list): void
    {
        foreach ($entity->$methodGet() as $row) {
            $id = $row->getId();
            if (!in_array($id, $list)) {
                $entity->$methodRemove($row);
                $row->$referenceRemove($entity);
                $this->manager->persist($row);
                $this->manager->persist($entity);
            }
        }

        $this->manager->flush();
    }

    /**
     * Supprimer les lia.
     *
     * @param mixed  $entity       Entity
     * @param string $method       method de liste
     * @param string $methodRemove methor à supprimer
     *
     * @return void
     */
    private function supprimer($entity, string $method, string $methodRemove): void
    {
        foreach ($entity->$method() as $row) {
            $entity->$methodRemove($row);
        }
    }

    /**
     * Set la table pour les childs.
     *
     * @param string $name   champs envoyer en post
     * @param mixed  $entity Classe de la table a modifier
     * @param string $method methode
     *                       à
     *                       utiliser
     *
     * @return void
     */
    private function setEntity($name, $entity, $method): void
    {
        $methodSet = str_replace('getRef', 'setRef', $method);
        $champs    = strtolower(str_replace('getRef', '', $method));
        $request   = $this->request;
        $post      = $request->request->get($name);
        if (isset($post[$champs]) && $this->container->has('bdd.' . $champs . '_manager')) {
            $identifier = $post[$champs];
            $manager    = $this->container->get('bdd.' . $champs . '_manager');
            $repository = $manager->getRepository();
            $data       = $repository->find($identifier);
            if ($data) {
                $entity->$methodSet($data);
            } else {
                $entity->$methodSet(NULL);
            }

            $manager->persistAndFlush($entity);
        }
    }

    /**
     * Persist le formulaire.
     *
     * @param Form $form formulaire
     *
     * @return void
     */
    private function setPersist(Form $form): void
    {
        $entityManager = $this->container->get('bdd.menu_manager');
        $translations  = $entityManager->getTranslations();
        $entity        = $this->entity;
        $name          = $form->getName();
        if (0 !== substr_count($name, 'langue')) {
            $post   = $this->request->request->get($name);
            $locale = str_replace('langue', '', $name);
            foreach ($post as $name => $val) {
                $translations->translate($entity, $name, $locale, $val);
            }

            $entity->setTranslatableLocale($this->params['langueprincipal']);
            $entityManager->refresh($entity);
            $entityManager->persistAndFlush($entity);
        } else {
            $entity->setTranslatableLocale($this->params['langueprincipal']);
            $entityManager->persistAndFlush($entity);
        }
    }

    /**
     * Traiter le formulaire si on peu continuer.
     *
     * @param string $etat ajouter ou modifier
     *
     * @return void
     */
    private function ifContinuer($etat): void
    {
        $methods       = get_class_methods($this->entity);
        $this->success = FALSE;
        foreach ($this->forms as $form) {
            $form->handleRequest($this->request);
            if ($form->isSubmitted() && $form->isValid() && $this->verifRecaptcha()) {
                if (!$this->success) {
                    $this->success = TRUE;
                    $flashBag      = $this->request->getSession()->getFlashBag();
                    $flashBag->add('success', 'Sauvegarde des données');
                }

                if (in_array('setUpdatedAt', $methods)) {
                    $this->entity->setUpdatedAt(new \DateTime());
                }

                $this->setPersist($form);
                $name = $form->getName();
                if (0 === substr_count($name, 'langue')) {
                    $this->delReference();
                    $this->setRef($form->getName());
                    if ('ajouter' === $etat) {
                        $this->new = TRUE;
                    }
                }

                $this->identifier = $this->entity->getId();
            }
        }
    }

    /**
     * Verifie si le code Captcha est correct.
     *
     * @return bool
     */
    private function verifRecaptcha(): bool
    {
        $param     = $this->paramService->listing();
        $recaptcha = 0;
        $post      = $this->request->request->all();
        if (isset($post['g-recaptcha-response'])) {
            $recaptcha = 1;
        }

        if (isset($param['recaptcha_clef']) && '' !== $param['recaptcha_clef']) {
            $recaptcha = $recaptcha + 1;
        }

        if (isset($param['recaptcha_secret']) && '' !== $param['recaptcha_secret']) {
            $recaptcha = $recaptcha + 1;
        }

        if (self::RECAPTCHA_ACCESS === $recaptcha) {
            $url     = 'https://www.google.com/recaptcha/api/siteverify?secret=';
            $url     = $url . $post['g-recaptcha-response'];
            $url     = $url . '&response=' . $this->request->request->get('g-recaptcha-response');
            $url     = $url . '&remoteip=' . $this->request->server->get('REMOTE_ADDR');
            $content = file_get_contents($url);
            $json    = json_decode($content, TRUE);
            if (FALSE === $json['success']) {
                return FALSE;
            }
        }

        return TRUE;
    }
}
