<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace UserBundle\Model;


use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class PasswordChange
{

    /**
     * @var string
     * @UserPassword()
     */
    private $oldPassword;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     *
     * @return PasswordChange
     */
    public function setOldPassword(string $oldPassword): PasswordChange
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     *
     * @return PasswordChange
     */
    public function setNewPassword(string $newPassword): PasswordChange
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}
