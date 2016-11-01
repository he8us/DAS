<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Service;

/**
 * Class RandomStringService
 *
 * @package CoreBundle\Service
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */
class RandomStringService
{

    /**
     * @param int $length
     *
     * @return string
     */
    public function generateRandomString($length = 13)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
