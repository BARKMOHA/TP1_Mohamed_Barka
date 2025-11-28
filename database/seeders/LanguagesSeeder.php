<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    //https://stackoverflow.com/questions/37369452/use-laravel-seed-and-sql-files-to-populate-database
    public function run(): void
    {
        DB::unprepared(
            file_get_contents(database_path('seeders/sql/languages.sql'))
        );
    }
}
