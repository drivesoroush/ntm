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
        return table_name('hosts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $scansTable = table_name('scans');
        $osGenericTable = table_name('os_generic');

        Schema::create($this->getTable(), function (Blueprint $table) use ($scansTable, $osGenericTable) {
            $table->unsignedBigInteger('id', true);
            $table->string('state')->default(HostStateEnum::STATE_UP);

            $table->bigInteger('address')->nullable();
            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
            $table->integer('type')->default(HostTypeEnum::NODE_HOST);

            $table->unsignedBigInteger('os_generic_id')->nullable();
            $table->foreign('os_generic_id')
                  ->references('id')
                  ->on($osGenericTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');

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
            $table->dropForeign(['os_generic_id']);
        });

        Schema::drop($this->getTable());
    }
}
