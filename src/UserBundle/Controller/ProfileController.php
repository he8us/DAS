<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Student;
use UserBundle\Entity\User;
use UserBundle\Form\ChangePasswordType;
use UserBundle\Form\StudentType;
use UserBundle\Form\UserProfileType;
use UserBundle\Model\PasswordChange;
use UserBundle\Services\StudentService;
use UserBundle\Services\UserService;

/**
 * Class ProfileController
 *
 * @package UserBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class ProfileController extends Controller
{

    /**
     * @return Response
     */
    public function viewAction()
    {
        return $this->render('UserBundle:Profile:show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }


    public function changePasswordAction(Request $request)
    {

        $passwordChange = new PasswordChange();
        $form = $this->createForm(ChangePasswordType::class, $passwordChange);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $this->getUser();
            $user->setPassword(null);
            $user->setPlainPassword($passwordChange->getNewPassword());

            $this->getUserService()->save($user);

            return $this->redirectToRoute('user_profile_view');
        }


        return $this->render('UserBundle:Profile:changePassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param string $confirmed
     *
     * @return Response
     */
    public function deleteAction(string $confirmed = 'no')
    {
        if ($confirmed === 'yes') {

        }

        return $this->render('UserBundle:Profile:delete.html.twig', [

        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $userType = $this->getUserType();
        $user = $this->getUser();
        $form = $this->createForm($userType, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUserService()->save($user);
            return $this->redirectToRoute("user_profile_view");
        }

        return $this->render("UserBundle:Profile:edit.html.twig", [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @return mixed
     */
    private function getUserType()
    {
        $user = $this->getUser();
        if ($user instanceof Student) {
            return StudentType::class;
        }

        return UserProfileType::class;
    }


    /**
     * @return StudentService|UserService
     */
    private function getUserService()
    {
        $user = $this->getUser();
        if ($user instanceof Student) {
            return $this->get('user.service.student');
        }

        return $this->get('user.service.user');
    }

}
