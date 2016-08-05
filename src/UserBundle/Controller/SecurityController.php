<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\Coordinator;
use UserBundle\Entity\CourseTitular;
use UserBundle\Entity\StudentParent;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;
use UserBundle\Entity\User;
use UserBundle\Form\LoginType;
use UserBundle\Form\UserType;

/**
 * Class SecurityController
 * @package UserBundle\Controller
 * @author  Cedric Michaux <cedric@he8us.be>
 */
class SecurityController extends Controller
{


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render("UserBundle:Security:login.html.twig",
            [
                'error' => $error,
                'last_username' => $lastUsername
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginStudentAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render("UserBundle:Security:student-login.html.twig",
            [
                'error' => $error,
                'last_username' => $lastUsername
            ]
        );
    }


    /**
     * @param Request $request
     *
     * @param         $role
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request, $role)
    {

        if($role == 'any'){
            return $this->displayRoleSelection();
        }

        $user  = $this->getUserTypeForRole($role);


        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();
            $user->setActive(true);
            $em->persist($user);
            $em->flush();

            $this->authenticateUser($user);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('UserBundle:Registration:register.html.twig', [
            "form" => $form->createView(),
            "role" => $role
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resettingRequestAction(Request $request)
    {

    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function requestCardAction(Request $request)
    {

    }

    /**
     * @param User $user
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function authenticateUser(User $user)
    {
        $providerKey = "main";

        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
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
        switch ($role){
            case "coordinator":
                return new Coordinator();
                break;

            case "teacher":
                return new Teacher();
                break;

            case "titular":
                return new Titular();
                break;

            case "course_titular":
                return new CourseTitular();
                break;

            case "parent":
                return new StudentParent();
                break;
        }
    }
}
