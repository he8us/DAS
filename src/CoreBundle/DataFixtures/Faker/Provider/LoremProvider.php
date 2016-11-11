<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CoreBundle\DataFixtures\Faker\Provider;


use Faker\Provider\Lorem;

/**
 * Class LoremProvider
 *
 * @package CoreBundle\DataFixtures\Faker\Provider
 *
 * @author Cedric Michaux <cedric@he8us.be>
 */

class LoremProvider
{
    /**
     * @example '<p>Sapiente sunt omnis.</p><p>Ut pariatur ad autem ducimus et. Voluptas rem modi dolorem amet.</p>'
     *
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    public static function htmlParagraphs($min, $max)
    {
        $paragraphs = Lorem::paragraphs(rand($min, $max));

        if(empty($paragraphs)){
            return '';
        }

        return '<p>' . join('</p><p>', $paragraphs) . '</p>';
    }
}
