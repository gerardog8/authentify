<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable(Config::get('authentify::tables.users'))) {
			Schema::create(Config::get('authentify::tables.users'), function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('email', 100)->unique();
				$table->string('password', 60);
				$table->string('name', 100);
				$table->boolean('active');
				$table->string('remember_token', 100);
				$table->datetime('active_at');
				$table->datetime('login_at');
				$table->timestamps();
			});
		}
		elseif (!Schema::hasColumn(Config::get('authentify::tables.users'), 'remember_token')) {
			Schema::table(Config::get('authentify::tables.users'), function(Blueprint $table)
			{
				$table->string('remember_token', 100);
			});
		}
		elseif (!Schema::hasColumn(Config::get('authentify::tables.users'), 'active')) {
			Schema::table(Config::get('authentify::tables.users'), function(Blueprint $table)
			{
				$table->boolean('active');
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists(Config::get('authentify::tables.users'));
	}

}
