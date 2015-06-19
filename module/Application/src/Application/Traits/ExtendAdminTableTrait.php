<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/27/15
 * Time: 12:59 PM
 */

namespace Application\Traits;


use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Stdlib\ResponseInterface;

trait ExtendAdminTableTrait
{
    /**
     * @param ResponseInterface $response
     * @param                                $html
     *
     * @return HttpResponse
     */
    public function prepareHtmlResponse(ResponseInterface $response, $html)
    {
        $response->setStatusCode(200);
        $response->setContent($html);
        return $response;
    }
}