<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateRelUserRoleTable
 *
 * @author Kovács Vince<vincekovacs@hotmail.com>
 */
class CreateRelUserRoleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = app()->make('db')->connection()->getSchemaBuilder();

        $schema->create(config('vi-kon.auth.table.rel__user__role'), function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on(config('vi-kon.auth.table.users'))
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
                  ->references('id')
                  ->on(config('vi-kon.auth.table.user_roles'))
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema = app()->make('db')->connection()->getSchemaBuilder();

        $schema->drop(config('vi-kon.auth.table.rel__user__role'));
    }
}
