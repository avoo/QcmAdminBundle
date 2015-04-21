<?php

namespace Qcm\Bundle\AdminBundle\Controller;

use Qcm\Component\User\Model\UserSessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StatisitcsController
 */
class StatisitcsController extends Controller
{
    /**
     * Stats action
     *
     * @param Request $request
     *
     * @return Response
     */
    public function statsAction(Request $request)
    {
        /** @var UserSessionInterface $userSession */
        $userSession = $this->get('qcm_core.controller.user_session')->findOr404($request);
        $statistics = $this->get('qcm_core.statistics')->execute($userSession);

        if (is_null($userSession->getConfiguration()->getEndAt())) {
            $this->get('session')->getFlashBag()->add('danger', 'qcm_admin.questionnaire.not_completed');

            return $this->redirect($this->generateUrl('qcm_admin_user_session_list'));
        }

        return $this->render('QcmAdminBundle:Statistics:statistics.html.twig', array(
            'user_session' => $userSession,
            'statistics' => $statistics
        ));
    }
}
