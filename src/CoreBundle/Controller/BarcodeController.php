<?php
/**
 * This file is part of the he8us/das package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace CoreBundle\Controller;



use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BarcodeController extends Controller
{


    /**
     * @param string $value
     * @param string $extension
     * @param string $barcodeType
     *
     * @return Response
     */
    public function generateAction(string $value, string $extension, string $barcodeType)
    {

        $headers  = $this->getHeaders($extension);

        return new Response($barcode, 200, $headers);
    }

    /**
     * @param $type
     *
     * @return BarcodeGeneratorPNG|BarcodeGeneratorJPG|BarcodeGeneratorSVG
     */
    private function getBarcodeGenerator($type)
    {
        switch ($type) {

            case 'png':
                return new BarcodeGeneratorPNG();

            case 'jpg':
                return new BarcodeGeneratorJPG();

            case 'svg':
            default:
                return new BarcodeGeneratorSVG();
        }
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function getHeaders($type)
    {
        return $this->getContentTypeHeaders($type);
    }

    /**
     * @param string $type
     * @param array  $headers
     *
     * @return array
     */
    private function getContentTypeHeaders(string $type, array $headers = [])
    {
        if ($type !== 'svg') {
            $headers['Content-Type'] = 'image/' . $type;
            return $headers;
        }

        $headers['Content-Type'] = 'image/svg+xml';
        return $headers;
    }

}
