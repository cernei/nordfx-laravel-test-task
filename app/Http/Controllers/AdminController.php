<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Faker;

class AdminController
{
    public function install(Response $response)
    {
         DB::statement('DROP TABLE IF EXISTS tickets;');
         DB::statement('
            CREATE TABLE tickets (
             id INT AUTO_INCREMENT PRIMARY KEY,
             username VARCHAR(255),
             user_number INT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;
        ');


        return $response->setContent('Created');
    }

    public function addTestCase(Response $response)
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10000; $i++) {
            $tickets = [];

            for ($k = 0; $k < 100; $k++) {
                $tickets[] = [
                    'username' => $faker->name,
                    'user_number' => mt_rand(1000000, 9999999),
                ];
            }
            DB::table('tickets')->insert($tickets);
        }

        return $response->setContent('added');
    }

}
