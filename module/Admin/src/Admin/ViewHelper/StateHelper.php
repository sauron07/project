<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/28/15
 * Time: 4:46 PM
 */

namespace Admin\ViewHelper;


use Zend\View\Helper\AbstractHelper;

class StateHelper extends AbstractHelper
{
    const ALIAS = 'stateHelper';

    protected $stateMap = [
        '1' => 'Activate',
        '2' => 'Registered',
        '3' => 'Blocked'
    ];

    public function __invoke($stateId)
    {
        return $this->stateMap[$stateId];
    }

}