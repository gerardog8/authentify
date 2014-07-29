<?php namespace GerardoG8\Authentify;

use Symfony\Component\Process\Exception\InvalidArgumentException;
use Config;

trait AuthentifyTrait {
	public function permissions() {
		return $this->morphToMany(Config::get('authentify::models.permission'), 'grantable', Config::get('authentify::tables.grantables'));
	}

	public function syncPermissions() {
		return $this->permissions()->sync(array_collection_ids(func_get_args()));
	}

	public function grant() {
		$permission_ids = array_diff(array_collection_ids(func_get_args(), Config::get('authentify::models.permission')), $this->permissions()->lists('id'));
		return count($permission_ids) ? $this->permissions()->attach($permission_ids) : false;
	}

	public function deny() {
		return $this->permissions()->detach(array_collection_ids(func_get_args(), Config::get('authentify::models.permission')));
	}

	public function can() {
		$permission_ids = array_diff(array_collection_ids(func_get_args(), Config::get('authentify::models.permission')), $this->permissions()->lists('id'));
		return !count($permission_ids);
	}
}