<?php

namespace app\index\controller;

use app\common\ControllerBase;

class Base extends ControllerBase
{
    public $userinfo;

    public function __construct()
    {
        parent::__construct();

        if ($this->request->param('userinfo'))
            $this->userinfo = $this->request->param('userinfo');
    }

}
