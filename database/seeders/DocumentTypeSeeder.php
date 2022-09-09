<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::create([
            'name' => 'photo'
        ]);

        DocumentType::create([
            'name' => 'signature'
        ]);

        DocumentType::create([
            'name' => 'satisfaction'
        ]);

        DocumentType::create([
            'name' => 'estimate'
        ]);

        DocumentType::create([
            'name' => 'contract'
        ]);
    }
}
