<?php 

if (!function_exists('array_collection_ids')) {
	function array_collection_ids ($collection, $of = null, $key = 'id', $key_str = 'name') {
		array_walk($collection, function (&$object) use ($of, $key_str, $key) {
			switch (true) {
				// If provided element is a numeric id
				case is_numeric($object): $object = array($object); break;
				// If provided element is an eloquent model
				case is_object($object) && isset($object->$key): $object = array($object->$key); break;
				// If provided element is an eloquent collection
				case is_object($object): $object = $object->lists($key); break;
				// If provided element is an array and has an id element
				case is_array($object) && isset($object[$key]): $object = array($object[$key]); break;
				// If provided element is an array of ids, do nothig
				case is_array($object) && count($object) == count(array_filter($object, 'is_numeric')): break;
				// If provided element is an array of arrays, fetch the id element
				case is_array($object) && count($object) == count(array_filter($object, 'is_array')): $object = array_fetch($object, 'id'); break;
				// If provided element is a string
				case is_string($object) && $of: $test = with(call_user_func(array($of, 'where'), $key_str, '=', $object))->first(); $object = $test ? array($test->id) : array(false); break;
				// If anything else is provided, throw error
				default: throw new InvalidArgumentException; break;
			}
		});

	

		return call_user_func_array('array_merge', $collection);
	}
}