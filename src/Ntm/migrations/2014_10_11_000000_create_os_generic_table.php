<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsGenericTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return table_name('os_generic');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $hostsTable = table_name('hosts');

        Schema::create($this->getTable(), function (Blueprint $table) use ($hostsTable) {
            $table->unsignedBigInteger('id', true);

            $table->string('name');
            $table->string('family');
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
