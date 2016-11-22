<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\Coordinator;
use UserBundle\Entity\CourseTitular;
use UserBundle\Entity\StudentParent;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;
use UserBundle\Entity\User;
use UserBundle\Form\UserRegisterType;

/**
 * Class SecurityController
 *
 * @package UserBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class SecurityController extends Controller
{


    /**
     * @return Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("UserBundle:Security:login.html.twig",
            [
                'error'         => $error,
                'last_username' => $lastUsername,
            ]
        );
    }

    /**
     * @return Response
     */
    public function loginStudentAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("UserBundle:Security:student-login.html.twig",
            [
                'error'         => $error,
                'last_username' => $lastUsername,
            ]
        );
    }


    /**
     * @param Request $request
     *
     * @param         $role
     *
     * @return Response
     */
    public function registerAction(Request $request, $role)
    {
        if ($role == 'any') {
            return $this->displayRoleSelection();
        }

        $user = $this->getUserTypeForRole($role);


        $form = $this->createForm(UserRegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $form->getData();
            $user->setActive(true);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->authenticateUser($user);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('UserBundle:Registration:register.html.twig', [
            "form" => $form->createView(),
            "role" => $role,
        ]);
    }

    /**
     * @return Response
     */
    private function displayRoleSelection()
    {
        return $this->render('UserBundle:Registration:choose-role.html.twig');
    }

    /**
     * @param $role
     *
     * @return Coordinator|CourseTitular|StudentParent|Teacher|Titular
     */
    private function getUserTypeForRole($role)
    {
        $className = $this->getClassFromString($role);

        if (!class_exists($className)) {
            return null;
        }

        return new $className();
    }

    /**
     * @param $role
     *
     * @return string
     */
    private function getClassFromString($role):string
    {
        $userType = str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($role))));

        if ('Parent' === $userType) {
            $userType = 'StudentParent';
        }

        $className = 'UserBundle\\Entity\\' . $userType;
        return $className;
    }


    /**
     * @param User $user
     */
    private function authenticateUser(User $user)
    {
        $providerKey = "main";

        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function resettingRequestAction(Request $request)
    {


    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function requestCardAction(Request $request)
    {

    }
}
