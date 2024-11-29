<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 他のSeederクラスを登録
        $this->call([
            UsersTableSeeder::class, // ユーザーデータのSeeder
            SubjectsTableSeeder::class, // 科目データのSeeder
        ]);
    }
}
