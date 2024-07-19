<?php

namespace Database\Seeders;

use App\Models\ChecklistItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChecklistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChecklistItem::factory(3)->create();
    }
}
