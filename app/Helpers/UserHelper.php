<?php

namespace App\Helpers;

use App\User;

class UserHelper
{
    /**
     * @property User $user
     **/
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function formatWallet(): array
    {
        $response = [];
        $wallet = $this->user->coins;

        foreach ($wallet as $item) {
            if ($item->pivot->balance > 0) {
                $response[] = [
                    'name' => $item->name,
                    'description' => $item->description,
                    'image' => $item->image,
                    'conversion' => [
                        'btc' => $item->conversion->btc,
                        'usd' => $item->conversion->usd,
                    ],
                    'balance' => $item->pivot->balance,
                ];
            }
        }

        return $response;
    }

    public function formatExchange(?string $name): array
    {
        $response = [];
        $wallet = $this->user->coins;

        foreach ($wallet as $item) {
            if (
                $item->pivot->balance > 0 
                && $item->name === $name
            ) {
                $balance = $item->pivot->balance;
                $response = [
                    'btc' => $item->conversion->btc * $balance,
                    'usd' => $item->conversion->usd * $balance,
                ];
            }
        }

        return $response;
    }
}
