<?php

namespace Mkk\PublicBundle\Controller;

use Mkk\PublicBundle\Form\ForgottenpasswordType;
use Mkk\PublicBundle\Form\LoginType;
use Mkk\SiteBundle\Lib\LibController;
use Mkk\SiteBundle\Service\GeocodeService;
use Mkk\SiteBundle\Service\ParamService;
use Mkk\SiteBundle\Service\TelephoneService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class DefaultController extends LibController
{
    /**
     * @var ParamService
     */
    protected $paramService;

    /**
     * @Route("/login", name="scripts.login")
     *
     * @param Request $request pile de requête
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        $session         = $request->getSession();
        $authErrorKey    = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;
        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (NULL !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = NULL;
        }

        if (!$error instanceof AuthenticationException) {
            $error = NULL; // The value does not come from the security component.
        }

        $lastUsername = (NULL === $session) ? '' : $session->get($lastUsernameKey);
        $lastUsername = '';
        $formLogin    = $this->formFactory->create(
            LoginType::class,
            NULL,
            [
                'last_username' => $lastUsername,
            ]
        );
        if (NULL !== $error) {
            $translate = $this->get('translator');
            $trad      = $translate->trans($error->getMessageKey(), $error->getMessageData(), 'security');
            $flashbag  = $request->getSession()->getFlashBag();
            $flashbag->add('warning', $trad);
        }

        $twigHtml = $this->render(
            'MkkPublicBundle:Default:login.html.twig',
            [
                'error'     => $error,
                'formLogin' => $formLogin->createView(),
            ]
        );

        return $twigHtml;
    }

    /**
     * @Route("/forgot", name="scripts.forgot")
     *
     * @return Response
     */
    public function forgot(): Response
    {
        $formForgot = $this->formFactory->create(
            ForgottenpasswordType::class,
            NULL,
            []
        );

        $twigHtml = $this->render(
            'MkkPublicBundle:Default:forgot.html.twig',
            [
                'formForgot' => $formForgot->createView(),
            ]
        );

        return $twigHtml;
    }

    /**
     * Verifie si le numéro de téléphone est correct.
     *
     * @Route("/telephone", name="scripts.telephone")
     *
     * @param Request          $request    Pile de requete
     * @param TelephoneService $serviceTel service de tel
     *
     * @return JsonResponse
     */
    public function telephone(Request $request, TelephoneService $serviceTel): JsonResponse
    {
        $numero = $request->request->get('telephone');
        $md5    = $request->request->get('md5');
        if ('' !== $numero) {
            if (0 !== substr_count($numero, ':')) {
                list($code, $chaine) = explode(':', $numero);
                unset($code);
            } else {
                $chaine = $numero;
            }

            $responsejson = $serviceTel->verif($chaine, $request->getLocale());
        } else {
            $responsejson = [];
        }

        $responsejson['md5'] = $md5;

        $json = new JsonResponse($responsejson);

        return $json;
    }

    /**
     * Affichage la page quand le javascript est désactivé.
     *
     * @Route("/javascript", name="scripts.nojs")
     *
     * @return Response
     */
    public function javascript(): Response
    {
        $htmlTwig = $this->render('MkkPublicBundle:Default:nojs.html.twig');

        return $htmlTwig;
    }

    /**
     * Permet d'afficher le code pour fileupload.
     *
     * @Route("/upload", name="scripts.upload")
     *
     * @return Response
     */
    public function upload(): Response
    {
        $htmlTwig = $this->render('MkkPublicBundle:Default:result.html.twig');

        return $htmlTwig;
    }

    /**
     * Affiche la page pour dire que le site est désactivé.
     *
     * @Route("/disable/", name="scripts.disable")
     *
     * @return Response
     */
    public function disable(): Response
    {
        $twigHtml = $this->render(
            'MkkPublicBundle:Default:disable.html.twig'
        );

        return $twigHtml;
    }

    /**
     * Permet d'afficher filemanager suivant les utilisateurs.
     *
     * @Route("/wysiwyg", name="scripts.wysiwyg")
     *
     * @param Request      $request      Pile de
     *                                   requête
     * @param ParamService $paramService Service des paramètres
     *
     * @return JsonResponse
     */
    public function wysiwyg(Request $request, ParamService $paramService): JsonResponse
    {
        $paramService = $this->get(ParamService::class);
        $generateurl  = 'site.index';
        $filename     = $request->server->get('SCRIPT_FILENAME');
        $url          = str_replace(['app.php', 'app_dev.php', '/web/'], '', $filename);
        $url          = substr($url, strrpos($url, '/') + 1);
        $filemanager  = 'plugins/responsivefilemanager/plugin.min.js';
        $json         = [
            'filemanager_title'      => 'Gestion des fichiers',
            'filemanager_access_key' => md5('48tp6QNp' . $url . date('m/Y')),
            'url'                    => $this->generateUrl($generateurl) . 'filemanager/',
            'external_plugins'       => [
                'filemanager' => $filemanager,
            ],
        ];

        unset($json['filemanager_title'], $json['filemanager_access_key'], $json['url'], $json['external_plugins']);

        $param            = $paramService->listing();
        $filemanagerDroit = $this->isFilemanagerDroit($param);

        if (1 === $filemanagerDroit) {
            $json['filemanager_access_key']    = md5('48tp6QNp' . $url . date('m/Y'));
            $json['external_filemanager_path'] = $this->generateUrl($generateurl, [], TRUE) . 'filemanager/';
            $json['external_plugins']          = [
                'filemanager' => $filemanager,
            ];
            unset($json['filemanager_access_key'], $json['external_filemanager_path'], $json['external_plugins']);
        }

        if (isset($json['filemanager_access_key'])) {
            $json['plugins'] = [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern responsivefilemanager',
                'emoticons template paste textcolor colorpicker textpattern',
            ];
            $json['plugins'] = [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern',
            ];
        } else {
            $json['plugins'] = [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern',
            ];
        }

        $json = new JsonResponse($json);

        return $json;
    }

    /**
     * @Route("/check-email", name="fos_user_resetting_check_email")
     * Tell the user to check his email provider.
     *
     * @param Request $request Pile de requete
     *
     * @return RedirectResponse|Response
     */
    public function checkEmail(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            $redirect = new RedirectResponse($this->generateUrl('user_login'));

            return $redirect;
        }

        $tokenLifetime = ceil($this->container->getParameter('fos_user.resetting.retry_ttl') / 3600);
        $twigHtml      = $this->render(
            'MkkPublicBundle:Default:check_email.html.twig',
            [
                'tokenLifetime' => $tokenLifetime,
            ]
        );

        return $twigHtml;
    }

    /**
     * Permet de connaitre le code postal.
     *
     * @Route("/cpville", name="scripts.cpville")
     *
     * @param GeocodeService $geocode Service de geocode
     *
     * @return JsonResponse
     */
    public function cpville(GeocodeService $geocode): JsonResponse
    {
        $json            = [];
        $json['reponse'] = $geocode->getcpville();
        $responsejson    = new JsonResponse($json);

        return $responsejson;
    }

    /**
     * J'ai le droit d'afficher filemanager ?
     *
     * @param array $param liste de data
     *
     * @return bool
     */
    private function isFilemanagerDroit(array $param): bool
    {
        $filemanagerDroit = FALSE;
        if (!isset($param['tinymce_filemanageracces'])) {
            return $filemanagerDroit;
        }

        $filemanageracces     = $param['tinymce_filemanageracces'];
        $tokenStorage         = $this->get('security.token_storage')->getToken();
        $authorizationChecker = $this->get('security.authorization_checker');
        $isauthorized         = $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if (!NULL !== $tokenStorage || !$isauthorized) {
            return $filemanagerDroit;
        }

        $idGroup = $tokenStorage->getUser()->getRefGroup()->getId();
        foreach ($filemanageracces as $groupId) {
            if ($idGroup === $groupId) {
                return TRUE;
            }
        }
    }
}
