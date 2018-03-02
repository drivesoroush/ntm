<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ntcm\Enums\HostStateEnum;
use Ntcm\Enums\HostTypeEnum;

class CreateHostScanTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.host_scan', 'mapper_host_scan');
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

            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id')
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
            $table->dropForeign(['scan_id']);
        });

        Schema::drop($this->getTable());
    }
}
