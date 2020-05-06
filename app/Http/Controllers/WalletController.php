<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * @return [json] currencies
     */
    public function getWallet()
    {
        $userHelper = new UserHelper(Auth::user());

        return response()->json([
            'currencies' => $userHelper->formatWallet(),
        ], 201);
    }
    
    /**
     * @param string name
     * @return [json] exchange
     */
    public function getExchange($name)
    {
        $userHelper = new UserHelper(Auth::user());

        return response()->json([
            'exchange' => $userHelper->formatExchange($name),
        ], 201);
    }
}
