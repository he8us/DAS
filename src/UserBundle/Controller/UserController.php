<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Controller;


use CoreBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\Coordinator;
use UserBundle\Entity\CourseTitular;
use UserBundle\Entity\StudentParent;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;
use UserBundle\Entity\User;
use UserBundle\Form\UserCreateType;
use UserBundle\Form\UserRoleType;
use UserBundle\Form\UserType;
use UserBundle\Services\UserService;

/**
 * Class UserController
 *
 * @package UserBundle\Controller
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserController extends AbstractCrudController
{
    protected $datatable = "user.datatable.users";

    protected $templateNamespace = "UserBundle:User:";

    /**
     * @param Request $request
     *
     * @param string  $type
     *
     * @return Response
     */
    public function newAction(Request $request, $type = 'any')
    {

        if ($type === 'any') {
            $form = $this->createForm(UserRoleType::class);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $role = $form->get('role');
                return $this->redirectToRoute('user_user_new', ['type' => $role->getData()]);
            }

            return $this->render('UserBundle:User:choose-role.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $user = $this->getUserTypeForRole($type);

        $form = $this->createForm(UserCreateType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUserService()->save($user);
            return $this->redirectToRoute('user_user_index');
        }

        return $this->render('UserBundle:User:new.html.twig', [
            'form' => $form->createView(),
        ]);
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
     * @return UserService
     */
    private function getUserService()
    {
        return $this->get('user.service.user');
    }

    /**
     * @param User $user
     *
     * @return Response
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('UserBundle:User:show.html.twig', [
            'user'        => $user,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param User $user
     *
     * @return mixed
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_user_delete', ['id' => $user->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @param Request $request
     * @param User    $user
     *
     * @return Response
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUserService()->save($user);
            return $this->redirectToRoute('user_user_edit', ['id' => $user->getId()]);
        }

        return $this->render('UserBundle:User:edit.html.twig', [
            'form'        => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a grade entity.
     *
     * @param Request $request
     *
     * @param User    $user
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUserService()->delete($user);
        }

        return $this->redirectToRoute('user_user_index');
    }
}
