<?php namespace GerardoG8\Authentify;

use GerardoG8\Evident\Model;
use Config;

class AuthentifyRole extends Model {
	use AuthentifyTrait;

	protected $table;
	protected $fillable = array('name', 'display_name');
	static public $rules = array(
		'name' => 'required|alpha_dash|max:255',
		'display_name' => 'required|max:255'
	);

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->table = Config::get('authentify::tables.roles');
	}

	public function users() {
		return $this->belongsToMany(Config::get('auth.model'), Config::get('authentify::tables.role_user'));
	}
}