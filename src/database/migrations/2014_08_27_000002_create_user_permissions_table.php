<?php

use Illuminate\Database\Schema\Blueprint;
use ViKon\Auth\Database\Migration\Migration;

/**
 * Class CreateUserPermissionsTable
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        static::$schema->create(static::$config->get('vi-kon.auth.table.user_permissions'), function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        static::$schema->drop(static::$config->get('vi-kon.auth.table.user_permissions'));
    }
}
