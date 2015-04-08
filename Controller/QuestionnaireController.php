<?php
namespace Qcm\Bundle\AdminBundle\Controller;

use Qcm\Component\User\Model\UserSessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class QuestionnaireController
 */
class QuestionnaireController extends Controller
{
    /**
     * Regenerate questionnaire action
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function regenerateAction(Request $request)
    {
        /** @var UserSessionInterface $userSession */
        $userSession = $this->get('qcm_core.controller.user_session')->findOr404($request);
        $generator = $this->get('qcm_core.question.generator');

        $generator->generate($userSession);
        $configuration = clone $userSession->getConfiguration();
        $userSession->setConfiguration($configuration);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($userSession);
        $manager->flush();

        return $this->redirect($this->generateUrl('qcm_admin_user_session_show', array(
            'id' => $userSession->getId()
        )));
    }
}
