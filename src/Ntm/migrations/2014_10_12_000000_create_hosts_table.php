<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ntcm\Enums\HostStateEnum;
use Ntcm\Enums\HostTypeEnum;

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
            $table->string('state')->default(HostStateEnum::STATE_UP);

            $table->bigInteger('address')->nullable();
            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
            $table->integer('type')->default(HostTypeEnum::NODE_HOST);

            //$table->unsignedBigInteger('scan_id')->nullable();
            //$table->foreign('scan_id')->references('id')->on($scansTable)->onDelete('set null')->onUpdate('set null');
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
