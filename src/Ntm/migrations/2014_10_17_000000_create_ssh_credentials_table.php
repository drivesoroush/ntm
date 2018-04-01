<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSshCredentialsTable extends Migration {

    /**
     * Get table name.
     *
     * @return string
     */
    function getTable()
    {
        return config('ntm.tables.ssh_credentials', 'mapper_ssh_credentials');
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
            $table->string('username');
            $table->string('password');
            $table->boolean('is_valid')->default(false);

            $table->unsignedBigInteger('host_id')->nullable();
            $table->foreign('host_id')
                  ->references('id')
                  ->on($hostsTable)
                  ->onDelete('set null')
                  ->onUpdate('set null');

            $table->timestamps();
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
