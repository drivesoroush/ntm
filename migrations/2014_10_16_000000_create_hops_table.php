<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHopsTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.hops', 'mapper_hops');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $scansTable = config('ntm.tables.scans', 'mapper_scans');
        $hostsTable = config('ntm.tables.hosts', 'mapper_hosts');

        Schema::create($this->getTable(), function (Blueprint $table) use ($scansTable, $hostsTable) {
            $table->unsignedBigInteger('id', true);

            $table->string('rtt');

            $table->unsignedBigInteger('address_first');
            $table->foreign('address_first')
                  ->references('id')
                  ->on($hostsTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');

            $table->unsignedBigInteger('address_second');
            $table->foreign('address_second')
                  ->references('id')
                  ->on($hostsTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');

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
        Schema::table($this->getTable(), function (Blueprint $table) {
            $table->dropForeign(['address_first']);
            $table->dropForeign(['address_second']);
            $table->dropForeign(['scan_id']);
        });

        Schema::drop($this->getTable());
    }
}
