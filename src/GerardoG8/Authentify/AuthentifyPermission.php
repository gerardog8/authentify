<?php namespace GerardoG8\Authentify;

use GerardoG8\Evident\Model;
use Config;

class AuthentifyPermission extends Model {
	protected $table;
	protected $fillable = array('name', 'display_name');
	static public $rules = array(
		'name' => 'required|alpha_dash|max:255',
		'display_name' => 'required|max:255'
	);

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->table = Config::get('authentify::tables.permissions');
	}

	public function users() {
		return $this->morphedByMany(Config::get('auth.model'), 'grantable', Config::get('authentify::tables.grantables'));
	}

	public function roles() {
		return $this->morphedByMany(Config::get('authentify::models.role'), 'grantable', Config::get('authentify::tables.grantables'));
	}
}