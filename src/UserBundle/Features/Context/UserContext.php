<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Features\Context;


use Behat\Behat\Definition\Call\Given;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelDictionary;
use CoreBundle\Features\Context\BaseContext;
use Doctrine\ORM\EntityManager;
use Exception;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\Coordinator;
use UserBundle\Entity\CourseTitular;
use UserBundle\Entity\Student;
use UserBundle\Entity\StudentParent;
use UserBundle\Entity\Teacher;
use UserBundle\Entity\Titular;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;

/**
 * Class UserContext
 *
 * @package UserBundle\Features\Context
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class UserContext extends BaseContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario
     */
    public function clearData()
    {

        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get("doctrine")->getManager();
        $entityManager->createQuery("DELETE FROM UserBundle:Student")->execute();
        $entityManager->createQuery("DELETE FROM UserBundle:User")->execute();
    }


    /**
     * @Given there are Students with the following details:
     *
     * @param TableNode $users
     */
    public function thereAreStudentsWithTheFollowingDetails(TableNode $users)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        foreach ($users->getColumnsHash() as $key => $val) {
            $student = new Student();

            $student->setActive(true);
            $student->setUsername($val['username']);
            $student->setBarcode($val['barcode']);
            $student->setFirstName($val['first_name']);
            $student->setLastName($val['last_name']);


            $entityManager->persist($student);
        }
        $entityManager->flush();
    }

    /**
     * @Given there is users with the following details:
     *
     * @param TableNode $users
     */
    public function thereIsUsersWithTheFollowingDetails(TableNode $users)
    {
        $entityManager = $this->getContainer()->get('doctrine')->getManager();
        foreach ($users->getColumnsHash() as $key => $val) {

            $user = isset($val['role']) ? $this->getUserTypeForRole($val['role']) : new User();

            $user->setActive(true);
            $user->setFirstName($val['first_name']);
            $user->setLastName($val['last_name']);
            $user->setUsername($val['username']);
            $user->setPlainPassword($val['plainPassword']);
            $user->setEmail($val['email']);
            $user->setPhone($val['phone']);

            $entityManager->persist($user);
        }

        $entityManager->flush();
    }

    /**
     * @param $role
     *
     * @return Coordinator|CourseTitular|StudentParent|Teacher|Titular|null
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
     * @Given I am authenticated as :role
     *
     * @param string $role
     */
    public function iAmAuthenticatedAs(string $role)
    {
        $container = $this->getContainer();
        $entityManager = $container->get('doctrine')->getManager();

        /** @var UserRepository $repo */
        $repo = $entityManager->getRepository(User::class);

        $user = $repo->findOneByRole('ROLE_' . $role);

        $this->login($user);

        $this->getLogger()
            ->info(
                sprintf(
                    "Logged in the user %s with role %s",
                    $user->getUsername(),
                    $user->getRoles()[0]
                )
            );
    }

    /**
     * @param User $user
     */
    private function login(User $user)
    {
        $session = $this->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = "main";

        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $this->getSession()->setCookie($session->getName(), $session->getId());
    }

    /**
     * @return Logger
     */
    private function getLogger(): Logger
    {
        return $this->getContainer()->get('logger');
    }

    /**
     * @Then the user :username should not have :field equal to :value
     *
     * @param $username
     * @param $field
     * @param $value
     *
     * @throws \Exception
     */
    public function theUserShouldNotHaveEqualTo($username, $field, $value)
    {
        $entityManager = $this->getContainer()->get("doctrine")->getManager();

        $repo = $entityManager->getRepository('UserBundle:User');

        $user = $repo->findOneBy(['username' => $username]);


        if ($user->{'get' . $field}() === $value) {
            throw new \Exception(sprintf("%s field is equal to %s", $field, $value));
        }
    }

    /**
     * @Then I follow the :page link
     *
     * @param $page
     */
    public function iFollowTheLink($page)
    {
        $page = str_replace(" ", "_", $page);
        $this->clickLink("_" . strtolower($page));
    }

    /**
     * @Then I should be on the Register page
     * @Then I should be on the :userType registration page
     *
     * @param string $userType
     */
    public function iShouldBeOnTheRegisterPage(string $userType = "any")
    {
        $userType = str_replace(" ", "_", $userType);
        $this->assertPageAddress($this->getRouter()->generate('user_security_register',
            ['role' => strtolower($userType)]));
    }

    /**
     * @return Router
     */
    private function getRouter():Router
    {
        return $this->getContainer()->get('router');
    }

    /**
     * @Given I am on the :userType registration page
     *
     * @param string $userType
     */
    public function iAmOnTheCoordinatorRegistrationPage(string $userType = "any")
    {
        $userType = str_replace(" ", "_", $userType);
        $this->visit($this->getRouter()->generate('user_security_register', ['role' => strtolower($userType)]));
    }

    /**
     * @When I submit the form
     */
    public function iSubmitTheForm()
    {
        $this->pressButton("_submit");
    }

    /**
     * @Given I am on the Register page
     */
    public function iAmOnTheRegisterPage()
    {
        $this->visit($this->getRouter()->generate('user_security_register'));
    }

    /**
     * @Then I should be welcomed
     */
    public function iShouldBeWelcomed()
    {
        $this->assertElementOnPage(".welcome-user");
    }

    /**
     * @Then I should be on the :pageType login page
     *
     * @param string $pageType
     */
    public function iShouldBeOnTheLoginPage(string $pageType)
    {
        $routeName = $this->getLoginRouteForUserType($pageType);

        return $this->assertPageAddress($this->getRouter()->generate($routeName));

    }

    /**
     * @param string $pageType
     *
     * @return string
     */
    private function getLoginRouteForUserType(string $pageType):string
    {
        $routeName = "user_security_login";
        if ("student" == strtolower($pageType)) {
            $routeName = "student_security_login";
            return $routeName;
        }
        return $routeName;
    }

    /**
     * @Given there is a :userType with credentials :username and :password in the database
     *
     * @param $userType
     * @param $username
     * @param $password
     *
     * @throws Exception
     */
    public function thereIsAWithCredentialsAndInTheDatabase($userType, $username, $password)
    {
        $user = $this->getUserTypeForRole($userType);
        if ($user == null) {
            throw new Exception("Unknown user type");
        }
        if ($user instanceof Student) {
            $user->setBarcode($password);
        } else {
            $user->setPlainPassword($password);
        }

        $user->setUsername($username);
        $user->setFirstName("test");
        $user->setLastName("test");
        $user->setEmail("test@example.org");
        $user->setActive(true);

        $entityManager = $this->getContainer()->get("doctrine")->getManager();

        $entityManager->persist($user);
        $entityManager->flush();
    }

    /**
     * @Given I am on the :userType login page
     *
     * @param $userType
     */
    public function iAmOnTheLoginPage($userType)
    {
        $routeName = $this->getLoginRouteForUserType($userType);
        $this->visit($this->getRouter()->generate($routeName));
    }

    /**
     * @Then I fill the login form with :username and :password
     *
     * @param $username
     * @param $password
     */
    public function iFillTheLoginFormWithAnd($username, $password)
    {
        $this->fillField("_username", $username);
        try {
            $this->fillField("_password", $password);
        } catch (Exception $e) {
            $this->fillField("_barcode", $password);
        }
    }

    /**
     * @Given I am on the :type list page
     *
     * @param $type
     */
    public function iAmOnTheListingPage($type)
    {
        $route = 'user_management_list';
        if (strtolower($type) === "student") {
            $route = 'student_management_list';
        }

        $this->visit($this->getRouter()->generate($route));
    }

    /**
     * @Then I should be on the Student Import page
     */
    public function iShouldBeOnTheStudentImportPage()
    {
        $this->assertPageAddress($this->getRouter()->generate('student_management_import'));
    }
}
