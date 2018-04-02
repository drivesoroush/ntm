<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostGroupTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return table_name('host_groups');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $hostsTable = table_name('hosts');
        $groupsTable = table_name('groups');

        Schema::create($this->getTable(), function (Blueprint $table) use ($hostsTable, $groupsTable) {
            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id')
                  ->references('id')
                  ->on($hostsTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');

            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')
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
            $table->dropForeign(['group_id']);
        });

        Schema::drop($this->getTable());
    }
}
