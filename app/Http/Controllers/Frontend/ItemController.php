<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Game;
use App\Services\Managers\GameManager;
use Illuminate\Http\Request;
use Wncms\Http\Controllers\Frontend\FrontendController;
use App\Traits\GameTraits;

class ItemController extends FrontendController
{
    use GameTraits;

    public function combine(Request $request)
    {
        //combine items
    }

    public function upgrade(Request $request)
    {
        //upgrade item
    }
}
