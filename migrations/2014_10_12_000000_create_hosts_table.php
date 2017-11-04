<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostsTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.hosts', 'mapper_hosts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $scansTable = config('ntm.tables.scans', 'mapper_scans');

        Schema::create($this->getTable(), function (Blueprint $table) use ($scansTable) {
            $table->unsignedBigInteger('id', true);
            $table->string('state');

            $table->integer('start');
            $table->integer('end');

            $table->unsignedBigInteger('scan_id')->nullable();
            $table->foreign('scan_id')
                  ->references('id')
                  ->on($scansTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');
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
