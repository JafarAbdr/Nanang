<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	$data = "";
	$disable = false;
	$disabled = "disabled";
	if(!is_null($sekolah)){
		$option="";
		while($sekolah->getNextCursor()){
			$disable = true;
			$disabled = "";
			$schId = $sekolah->getIdentified();
			$option .= '<option value="SCH'.substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6).'">'.$sekolah->getNama().'</option>';
		}
		$data = '<div class="form-group">
					<div class="col-sm-3">
						<label for="nama" class="control-label">Nama Sekolah</label>
					</div>
					<div class="col-sm-9">
						<select '.$disabled.' name="nama" class="form-control select2-list" id="nama" data-placeholder="">
							<option value="">----------------- Pilih Sekolah ---------------------</option>
							'.$option.'
						</select>
					</div>
				</div>';
	}else if(!is_null($allow)){
		if($allow){
			$disable=true;
			$disabled="";
		}
	}
    echo json_encode(array(
        "formTarget"=>$baseUrl."Sekolah/add.jsp",
        "header"=>$header,
        "yes"=>$disable,
        "contentForm"=> $data.'
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="guru" class="control-label">Guru</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="guru" id="guru" class="form-control" placeholder="Nama Guru">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nip" class="control-label">Nip</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="nip" id="nip" class="form-control" placeholder="Nip Guru">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="col-sm-9">
                    <input type="email" '.$disabled.' name="email" id="email" class="form-control" placeholder="Email Guru">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nohp" class="control-label">No Handphone</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="nohp" id="nohp" class="form-control" placeholder="No handphone Guru">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="idline" class="control-label">ID Line</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="idline" id="idline" class="form-control" placeholder="ID Line">
                </div>
            </div>
        '
    ))
?>
