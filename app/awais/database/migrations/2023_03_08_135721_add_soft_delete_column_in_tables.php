<?php

use App\Awais\Helper\SoftDeleteables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AddSoftDeleteColumnInTables extends Migration
{

    /**
     * Author: Awais Ejaz
     * add soft delete in multiple tables
     */
    protected $tables = [];

    public function __construct()
    {
        $this->tables = SoftDeleteables::$tables;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        foreach ($this->tables as $table) {
            $table = Str::snake(Str::plural($table));
            $this->downTable($table);
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            $table = Str::snake(Str::plural($table));
            $this->downTable($table);
        }
    }

    public function downTable($table)
    {
        if (Schema::hasColumn($table, 'deleted_at')) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
}
