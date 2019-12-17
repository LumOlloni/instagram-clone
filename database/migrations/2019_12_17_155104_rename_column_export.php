<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnExport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('export', function(Blueprint $table) {
            $table->renameColumn('Export_Path', 'export_path_file');
            $table->renameColumn('Processing', 'processing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('export', function(Blueprint $table) {
            $table->renameColumn('Export_Path', 'export_path_file');
            $table->renameColumn('Processing', 'processing');
        });
    }
}
