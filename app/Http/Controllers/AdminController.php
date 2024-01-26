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
        DB::statement('DROP TABLE IF EXISTS results;');
        DB::statement('
            CREATE TABLE tickets (
             id INT AUTO_INCREMENT PRIMARY KEY,
             username VARCHAR(255),
             user_number INT,
             date_bought DATETIME
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;
        ');
        DB::statement('
            CREATE TABLE results (
             id INT AUTO_INCREMENT PRIMARY KEY,
             draw_date DATETIME,
             prize INT,
             winning_number INT,
             winners TEXT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 DEFAULT COLLATE utf8_unicode_ci;
        ');

        return $response->setContent('Created');
    }

    public function addTestCase(Response $response)
    {
        $faker = Faker\Factory::create();
        $now = now();
        for ($i = 0; $i < 10000; $i++) {
            $tickets = [];

            for ($k = 0; $k < 100; $k++) {
                $tickets[] = [
                    'username' => $faker->name,
                    'user_number' => mt_rand(1000000, 9999999),
                    'date_bought' => $now,
                ];
            }
            DB::table('tickets')->insert($tickets);
        }

        return $response->setContent('added');
    }

}
