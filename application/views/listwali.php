<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	$dataS = '<option value=""> Pilih Guru </option>';
	if(!is_null($no)){
		$dataS ="";
	}
	$data = '
	<select disabled name="guru" class="form-control select2-list" id="guru" data-placeholder="">
		'.$dataS.'
	</select>
	';
	if(!is_null($guru)){
		$option="";
		foreach($guru as $value){
			$schId = $value['identified'];
			$option .= '<option value="TEACH'.substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6).'">'.$value['nama'].'</option>';
		}
		$data = '<select name="guru" class="form-control select2-list" id="guru" data-placeholder="">
					'.$dataS.'
					'.$option.'
				</select>
				';
	}
	echo $data;
?>
