<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScansTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.scans', 'mapper_scans');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->unsignedBigInteger('id', true);

            $table->unsignedInteger('user_id');

            $table->string('ranges');
            $table->boolean('ports')->default(true);
            $table->boolean('os')->default(true);

            $table->integer('total_discovered')->default(0);
            $table->integer('state')->default(0);

            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->getTable());
    }
}
