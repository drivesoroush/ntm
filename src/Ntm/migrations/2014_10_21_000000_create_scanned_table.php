<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScannedTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return table_name('scanned');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $hostsTable = table_name('hosts');
        $scansTable = table_name('scans');

        Schema::create($this->getTable(), function (Blueprint $table) use ($hostsTable, $scansTable) {
            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id')
                  ->references('id')
                  ->on($hostsTable)
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('scan_id')->nullable();
            $table->foreign('scan_id')
                  ->references('id')
                  ->on($scansTable)
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
            $table->dropForeign(['host_id']);
            $table->dropForeign(['scan_id']);
        });

        Schema::drop($this->getTable());
    }
}
