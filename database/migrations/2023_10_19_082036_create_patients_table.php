<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('m_name')->nullable();
            $table->string('l_name');
            $table->string('gender');
            $table->string('occupation');
            $table->string('phisical_address');
            $table->string('phone');
            $table->string('DOB');
            $table->string('kins_name')->nullable();
            $table->string('kins_mobile')->nullable();
            $table->unsignedBigInteger('createdBy');
            $table->foreign('createdBy')->references('id')->on('users');
            $table->string('display_id', 6);
            $table->timestamps();
        });

        // Generate initial display IDs with leading zeros for existing records, if any
        $existingPatients = DB::table('patients')->get();
        $displayId = 1;
        foreach ($existingPatients as $patient) {
            $formattedDisplayId = sprintf('%06d', $displayId);
            DB::table('patients')->where('id', $patient->id)->update(['display_id' => $formattedDisplayId]);
            $displayId++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
