<?php namespace GerardoG8\Authentify;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use GerardoG8\Evident\Model;
use Config;
use Hash;

class AuthentifyUser extends Model implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait, AuthentifyTrait;

	protected $hidden = array('password', 'remember_token');
	protected $fillable = array('password', 'email', 'name');
	protected $table;
	protected static $auto_validate = false;
	protected static $rules = array(
		'email' => 'required|email',
		'password' => 'required|alphaNum|min:3',
		'password_confirmation' => 'sometimes|alphaNum|min:3|same:password',
		'name' => 'required|max:200'
	);

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->table = Config::get('authentify::tables.users');
	}

	public function setPasswordAttribute($password) {
		$this->attributes['password'] = Hash::make($password);
	}

	public function setPasswordConfirmationAttribute($password) {}

	public function roles() {
		return $this->belongsToMany(Config::get('authentify::models.role'), Config::get('authentify::tables.role_user'));
	}

	public function hasRoles() {
		$role_ids = array_diff(array_collection_ids(func_get_args(), Config::get('authentify::models.role')), $this->roles()->lists('id'));
		return !count($role_ids);
	}

	public function addRoles() {
		$role_ids = array_diff(array_collection_ids(func_get_args(), Config::get('authentify::models.role')), $this->roles()->lists('id'));
		return count($role_ids) ? $this->roles()->attach($role_ids) : false;
	}

	public function removeRoles() {
		return $this->roles()->detach(array_collection_ids(func_get_args(), Config::get('authentify::models.role')));
	}

	public function syncRoles() {
		return $this->roles()->sync(array_collection_ids(func_get_args(), Config::get('authentify::models.role')));
	}

	public function can() {
		$queried_role_ids = array_collection_ids(func_get_args(), Config::get('authentify::models.permission'));
		$role_permission_ids = array_fetch(call_user_func_array('array_merge', array_fetch($this->roles()->with('permissions')->get()->toArray(), 'permissions')), 'id');
		$permission_ids = $this->permissions()->lists('id');
		return !count(array_diff($queried_role_ids, $permission_ids)) || !count(array_diff($queried_role_ids, $role_permission_ids));
	}
}