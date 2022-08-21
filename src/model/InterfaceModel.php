<?php

interface InterfaceModel
{
	public function table();

	public function __construct();

	public function All($filter);

	public function One($id, $filter);

	public function Insert($data);

	public function Update($id, $data);

	public function Delete($id);
}