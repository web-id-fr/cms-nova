<?php

namespace Database\Seeders\Components;

use Illuminate\Database\Seeder;
use Webid\CmsNova\App\Models\Components\BreadcrumbComponent;

class BreadcrumbComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BreadcrumbComponent::factory()->create([
            'name' => 'Breadcrumb',
        ]);
    }
}
