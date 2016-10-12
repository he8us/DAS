<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Features\Context;


use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;

/**
 * Class BaseContext
 * Some tricks from: http://www.tentacode.net/10-tips-with-behat-and-mink
 *
 * @package CoreBundle\Features\Context
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class BaseContext extends MinkContext
{

    use KernelDictionary;


    public function __call($method, $parameters)
    {
        // we try to call the method on the Page first
        $page = $this->getSession()->getPage();
        if (method_exists($page, $method)) {
            return call_user_func_array([$page, $method], $parameters);
        }

        // we try to call the method on the Session
        $session = $this->getSession();
        if (method_exists($session, $method)) {
            return call_user_func_array([$session, $method], $parameters);
        }

        // could not find the method at all
        throw new \RuntimeException(sprintf(
            'The "%s()" method does not exist.', $method
        ));
    }


    protected function throwExpectationException($message)
    {
        throw new ExpectationException($message, $this->getSession());
    }
}
