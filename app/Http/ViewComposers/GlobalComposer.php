<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class GlobalComposer {

    /**
     * Create a new Global View Composer.
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to every view.
     *
     * @param  View $view
     */
    public function compose(View $view)
    {
        $dispatcher = app('Dingo\Api\Dispatcher');
        $dingo_v1 = app('Dingo\Api\Routing\UrlGenerator')->version('v1');

        $view->with([
            'dispatcher' => $dispatcher,
            'dingo_v1'   => $dingo_v1
        ]);
    }

}