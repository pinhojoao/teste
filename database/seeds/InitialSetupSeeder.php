<?php

use Illuminate\Database\Seeder;
use App\Conversion;
use App\Coin;
use App\User;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conversion = Conversion::create([
            'btc' => 1,
            'usd' => 6973.18,
        ]);

        $btc = Coin::create([
            'name' => 'BTC',
            'description' => 'Bitcoin',
            'image' => 'http://altcoinlab.netxs.com.br/test/icons/bitcoin.png',
        ]);

        $btc->conversion()->associate($conversion);
        $btc->save();

        $conversion = Conversion::create([
            'btc' => 0.002,
            'usd' => 132.19,
        ]);

        $eth = Coin::create([
            'name' => 'ETH',
            'description' => 'Ethereum',
            'image' => 'http://altcoinlab.netxs.com.br/test/icons/ethereum.png',
        ]);

        $eth->conversion()->associate($conversion);
        $eth->save();

        $user = User::create([
            'name' => 'Thiago Molina',
            'email' => 't.molinex@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('nex@73'),
            'remember_token' => Str::random(10),
        ]);

        $user->coins()->sync([
            $btc->id => ['balance' => 0], 
            $eth->id => ['balance' => 2.13], 
        ]);

        Artisan::call('passport:client', [
            '--personal' => true,
            '--name' => 'Molinex',
        ]);
    }
}
