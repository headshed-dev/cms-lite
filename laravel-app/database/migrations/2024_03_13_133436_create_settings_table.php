<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('label');
            $table->text('value')->nullable();
            $table->json('attributes')->nullable();
            $table->string('type');
            $table->timestamps();
        });

        Setting::create([
            'key' => 'site_name',
            'label' => 'Site Name',
            'value' => null,
            'type' => 'text',
        ]);

        Setting::create([
            'key' => 'site_description',
            'label' => 'Site Description',
            'value' => null,
            'type' => 'text',
        ]);

        Setting::create([
            'key' => 'site_keywords',
            'label' => 'Site Keywords',
            'value' => null,
            'type' => 'text',
        ]);

        Setting::create([
            'key' => 'environment',
            'label' => 'Environment',
            'value' => 'production',
            'type' => 'select',
            'attributes' => [
                'options' => [
                    'production' => 'Production',
                    'staging' => 'Staging',
                    'local' => 'Local',
                ],
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
