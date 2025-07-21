<?php

namespace Notabenedev\StaffTypes\Events;

use App\StaffParam;
use Illuminate\Queue\SerializesModels;

class ParamUpdate
{
    use SerializesModels;

    public $param;
    public $morph;
    public $action;

    /**
     * Create a new event instance.
     *
     * ImageUpdate constructor.
     * @param StaffParam $param
     * @param string $action
     */
    public function __construct(StaffParam $param, string $action = "undefined")
    {
        $this->param = $param;
        $this->morph = $param->paramable;
        $this->action = $action;
    }
}
