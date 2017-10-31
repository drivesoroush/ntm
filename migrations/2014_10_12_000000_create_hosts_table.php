<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHostsTable extends Migration {

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
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->engine = "innoDB";

            $table->unsignedBigInteger('id', true);
            $table->string('state');

            $table->integer('starttime');
            $table->integer('endtime');

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
