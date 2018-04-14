<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateCommandOsGenericTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return table_name('command_os_generic');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $osTable = table_name('os_generic');
        $commandsTable = table_name('commands');

        Schema::create($this->getTable(), function (Blueprint $table) use ($osTable, $commandsTable) {
            $table->unsignedBigInteger('id', true);

            $table->unsignedBigInteger('os_generic_id');
            $table->foreign('os_generic_id')
                  ->references('id')
                  ->on($osTable)
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('command_id');
            $table->foreign('command_id')
                  ->references('id')
                  ->on($commandsTable)
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
        Schema::drop($this->getTable());
    }
}
