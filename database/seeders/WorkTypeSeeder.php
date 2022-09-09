<?php

namespace Database\Seeders;

use App\Models\WorkType;
use Illuminate\Database\Seeder;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkType::create([
            'name' => 'Mold remediation'
        ]);

        WorkType::create([
            'name' => 'Water mitigation'
        ]);

        WorkType::create([
            'name' => 'TARP'
        ]);

        WorkType::create([
            'name' => 'Mold assessment'
        ]);
    }
}
