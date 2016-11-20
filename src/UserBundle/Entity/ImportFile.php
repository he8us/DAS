<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace UserBundle\Entity;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImportFile
{
    /**
     * @var UploadedFile
     * @Assert\File(
     *     mimeTypesMessage="user.student.import.file.error.xls",
     *     mimeTypes={
     *          "application/vnd.ms-excel",
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
     *     }
     * )
     * @Assert\NotBlank(message="user.student.import.file.error.blank")
     */
    protected $file;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

}
