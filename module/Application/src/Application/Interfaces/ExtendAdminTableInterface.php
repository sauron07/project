<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/27/15
 * Time: 12:56 PM
 */

namespace Application\Interfaces;

use Zend\Stdlib\ResponseInterface;

/**
 * Interface ExtendAdminTableInterface
 * @package Application\Interfaces
 */
interface ExtendAdminTableInterface
{
    /**
     * @param ResponseInterface $response
     * @param                   $html
     *
     * @return mixed
     */
    public function prepareHtmlResponse(ResponseInterface $response, $html);
}
