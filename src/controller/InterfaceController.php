<?php

interface InterfaceModel
{
	public function __construct();

	public function Save($filter);

	public function Update($id, $filter);

	public function Show($data);

	public function Index($id, $data);

	public function Delete($id);
}