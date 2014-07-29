<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrantablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('authentify::tables.grantables'), function(Blueprint $table)
		{
			$table->integer('permission_id')->index()->foreign()->references('id')->on('permissions');
			$table->integer('grantable_id')->index();
			$table->string('grantable_type', 50)->index();
			$table->primary(array('permission_id', 'grantable_id', 'grantable_type'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists(Config::get('authentify::tables.grantables'));
	}

}
