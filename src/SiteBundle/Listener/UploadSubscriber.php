<?php

namespace Mkk\SiteBundle\Listener;

use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Mkk\SiteBundle\Handler\UploadHandler;
use Mkk\SiteBundle\Service\AnnotationReaderService;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UploadSubscriber implements EventSubscriber
{
    protected $accessor;

    /**
     * @var AnnotationReaderService
     */
    private $reader;
    /**
     * @var UploadHandler
     */
    private $handler;

    /**
     * Init subscriber.
     *
     * @param AnnotationReaderService $reader  ReaderService
     * @param UploadHandler           $handler UploadHandler
     */
    public function __construct(AnnotationReaderService $reader, UploadHandler $handler)
    {
        $this->handler  = $handler;
        $this->reader   = $reader;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Donne les évènements à écouter.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    /**
     * Evenement Pre PERSIST doctrine.
     *
     * @param EventArgs $event evenement
     *
     * @return void
     */
    public function prePersist(EventArgs $event): void
    {
        $this->preEvent($event);
    }

    /**
     * Evenement Pre UPDATE doctrine.
     *
     * @param EventArgs $event evenement
     *
     * @return void
     */
    public function preUpdate(EventArgs $event): void
    {
        $this->preEvent($event);
    }

    /**
     * Regroupement preUpdate + prePersist.
     *
     * @param EventArgs $event evenement
     *
     * @return void
     */
    private function preEvent(EventArgs $event): void
    {
        $entity           = $event->getEntity();
        $uploadableFields = $this->reader->getUploadableFields($entity);
        foreach ($uploadableFields as $property => $annotation) {
            $md5 = $this->accessor->getValue($entity, $property);
            if ('' !== $md5) {
                $this->handler->removeOldFile($entity, $annotation);
                $this->handler->uploadFile($entity, $property, $annotation);
                $this->handler->removeMD5FolderFile($entity, $property);
            }
        }
    }
}
