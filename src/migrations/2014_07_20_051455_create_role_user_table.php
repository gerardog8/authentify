<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('authentify::tables.role_user'), function(Blueprint $table)
		{
			$table->integer('role_id')->index()->foreign()->references('id')->on('roles');
			$table->integer('user_id')->index()->foreign()->references('id')->on('users');
			$table->primary(array('role_id', 'user_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists(Config::get('authentify::tables.role_user'));
	}

}
