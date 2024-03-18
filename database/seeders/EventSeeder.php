<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $names = [
        //     'Danse-thérapie',
        //     'Art-thérapie',
        //     'Prendre la parole en public',
        //     'Les bases de la PNL',
        //     'Définir ses objectifs de vie',
        //     'Gérer les conflits',
        // ];

        // foreach ($names as $name) {
        //     DB::table('events')->insert([
        //         'name' => $name,
        //     ]);
        // }

        Event::factory(10)->create();
    }
}
