<?php

namespace Mkk\SiteBundle\Service;

use Mkk\SiteBundle\Table\TableService;
use Swift_Message;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailerService
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TableService
     */
    private $mailManager;

    /**
     * @var ParamService
     */
    private $paramService; /**
     * @var array
     */
    private $params;

    /**
     * Init service.
     *
     * @param ContainerInterface $container container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container    = $container;
        $this->mailManager  = $container->get('bdd.mailer_manager');
        $this->paramService = $container->get(ParamService::class);
        $this->params       = $this->paramService->listing();
    }

    /**
     * Envoi un mail.
     *
     * @param array $tab data pour le mail
     *
     * @return void
     */
    public function send(array $tab): void
    {
        $subject      = isset($tab['subject']) ? $tab['subject'] : '';
        $from         = isset($tab['from']) ? $tab['from'] : '';
        $emailTo      = isset($tab['to']) ? $tab['to'] : '';
        $body         = isset($tab['content']) ? $tab['content'] : '';
        $fichiers     = isset($tab['fichiers']) ? $tab['fichiers'] : [];
        $mailerEntity = $this->mailManager->getTable();
        $mailer       = new $mailerEntity();
        $mailer->setSubject($subject);
        $mailer->setFrom($from);
        $this->setMailerReply($mailer, $tab);
        $this->setMailerCC($mailer, $tab);

        $mailer->setTo($emailTo);
        if ('' === $body) {
            return;
        }

        $mailer->setBody($body);
        $this->mailManager->persistAndFlush($mailer);
        $this->setMailerFile($mailer, $fichiers);
        $this->mailManager->persistAndFlush($mailer);

        $titre = '';
        if (isset($this->params['meta_titre'])) {
            $titre = $this->params['meta_titre'];
        }

        $mail = \Swift_Message::newInstance();
        $mail->setSubject($mailer->getSubject());
        if (isset($this->params['meta_titre'])) {
            $from = [$mailer->getFrom() => $this->params['meta_titre']];
        } else {
            $from = $mailer->getFrom();
        }

        $mail->setFrom($from);
        $this->mailReplyTO($mail, $mailer);
        $this->mailCc($mail, $mailer);
        $mail->setTo($mailer->getTo());
        $body = $mailer->getBody();
        $mail->setBody(strip_tags($body));
        $mail->addPart($body, 'text/html');
        $fichiers = $mailer->getFichiers();
        $this->mailAttach($mail, $fichiers);
        $this->container->get('mailer')->send($mail);
    }

    /**
     * Remplit CC.
     *
     * @param mixed $mailer Table mailer
     * @param array $tab    data pour le mail
     *
     * @return void
     */
    private function setMailerCC($mailer, array $tab): void
    {
        if (isset($tab['cc'])) {
            $mailer->setCc($tab['cc']);
        }
    }

    /**
     * Remplit reply.
     *
     * @param mixed $mailer Table mailer
     * @param array $tab    data pour le mail
     *
     * @return void
     */
    private function setMailerReply($mailer, array $tab): void
    {
        if (isset($tab['reply'])) {
            $mailer->setReply($tab['reply']);
        }
    }

    /**
     * Ajoute des fichiers.
     *
     * @param mixed $mailer   Table mailer
     * @param array $fichiers fichiers a ajouter
     *
     * @return void
     */
    private function setMailerFile($mailer, array $fichiers): void
    {
        if (0 !== count($fichiers)) {
            $id = $mailer->getId();
            if (!is_dir('fichiers/mailer/' . $id)) {
                mkdir('fichiers/mailer/' . $id);
            }

            $newFile = [];
            foreach ($fichiers as $nom => $tmpFile) {
                $file = 'fichiers/mailer/' . $id . '/' . $nom;
                copy($tmpFile, $file);
                $newFile[] = $file;
            }

            $mailer->setFichiers($newFile);
        }
    }

    /**
     * Attache les fichiers.
     *
     * @param Swift_Message $mail     swift mail
     * @param array         $fichiers fichiers attaché au la table
     *                                mailer
     *
     * @return void
     */
    private function mailAttach(Swift_Message $mail, array $fichiers): void
    {
        if (0 !== count($fichiers)) {
            return;
        }

        foreach ($fichiers as $file) {
            $nom        = substr($file, strrpos($file, '/'));
            $attachment = \Swift_Attachment::fromPath($file)->setFilename($nom);
            $mail->attach($attachment);
        }
    }

    /**
     * Remplit replyCC au mail.
     *
     * @param Swift_Message $mail   swift mail
     * @param mixed         $mailer Table mailer
     *
     * @return void
     */
    private function mailCc(Swift_Message $mail, $mailer): void
    {
        $emailCc = $mailer->getCc();
        if (0 !== count($emailCc)) {
            $mail->setCc($emailCc);
        }
    }

    /**
     * Remplit replyTo au mail.
     *
     * @param Swift_Message $mail   swift mail
     * @param mixed         $mailer Table mailer
     *
     * @return void
     */
    private function mailReplyTO(Swift_Message $mail, $mailer): void
    {
        if ('' !== $mailer->getReply()) {
            $mail->setReplyTo($mailer->getReply());
        }
    }
}
