<?php

namespace HubertNNN\FlowPlayer\Integration\Laravel;

use Illuminate\Support\Facades\Facade;

class FlowPlayerFacade extends Facade {
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'HubertNNN\FlowPlayer\Contracts\FlowPlayer'; // the IoC binding.
    }
}
