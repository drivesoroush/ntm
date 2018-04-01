<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortsTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.ports', 'mapper_ports');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $hostsTable = config('ntm.tables.hosts', 'mapper_hosts');

        Schema::create($this->getTable(), function (Blueprint $table) use ($hostsTable) {
            $table->unsignedBigInteger('id', true);

            //$table->bigInteger('address');
            $table->string('protocol');
            $table->string('port_id');
            $table->string('state');
            $table->string('reason');
            $table->string('service');
            $table->string('method');
            $table->string('conf');
            $table->string('product')->nullable();
            $table->string('version')->nullable();
            $table->string('extra_info')->nullable();

            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id')
                  ->references('id')
                  ->on($hostsTable)
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
            $table->dropForeign(['host_id']);
        });

        Schema::drop($this->getTable());
    }
}
