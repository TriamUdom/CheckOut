<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('user')->insert([
            'username' => 'test',
            'password' => '$2y$10$DenNYfcQseYC4hxgKndZXecsgmrSovOwYbvJuwDYrXjmUbMmmpT5m',
            'google2fa_secret' => 'GSNCEGUFFTEVGN2PVSHQLMMPC57IPHX5',
        ]);
    }
}
