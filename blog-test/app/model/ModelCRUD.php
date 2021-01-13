<?php


namespace model;


interface ModelCRUD {
	
	public function create($data);
	
	public function get($index);
	
	public function update($index, $data);
	
	public function delete($index);

}
