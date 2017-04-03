<?php

namespace Component\Library\Core;

use Zend\View\Model\JsonModel;

/**
 * Class AbstractApiController
 *
 * @package Component\Library\Core
 */
class AbstractApiController extends AbstractController
{

    /**
     * @return JsonModel
     */
    public function success()
    {
        $res['status'] = true;
        $res['data'] = $this->dto;
        return new JsonModel($res);
    }

    /**
     * @return JsonModel
     */
    public function failure()
    {
        $res['status'] = false;
        $res['data'] = $this->dto;
        return new JsonModel($res);
    }

}