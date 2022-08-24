<?php

class ModelController {

	public function many($query){
		$cnt 	= 0;
		$array 	= array();

		while($r = $query->fetch_array()){
			$array[$cnt] = new stdClass();
			$cnt2 =	1;
			foreach ($r as $key => $v) {
				if($cnt2>0 && $cnt2%2==0){ 
					$array[$cnt]->$key = $v;
				}
				$cnt2++;
			}
			$cnt++;
		}
		return $array;
	}

	public function one($query){
		$cnt 	= 0;
		$found 	= null;
		$data 	= new stdClass();
		while($r = $query->fetch_array()){
			$cnt = 1;
			foreach ($r as $key => $v) {
				if($cnt>0 && $cnt%2==0){ 
					$data->$key = $v;
				}
				$cnt++;
			}
			
			$found = $data;
		}
		return $found;
	}

}



?>