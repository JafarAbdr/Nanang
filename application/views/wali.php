<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	$data = "";
	$disable = false;
	$disabled = "disabled";
	if($kode == 1){
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
					</div>
					<div class="form-group">
						<div class="col-sm-3">
							<label for="guru" class="control-label">Nama Guru</label>
						</div>
						<div class="col-sm-9" id="listGuru">
							<select '.$disabled.' name="guru" class="form-control select2-list" id="guru" data-placeholder="">
								<option value="">----------------- Pilih Guru ---------------------</option>
							</select>
						</div>
					</div>
					';
		}else if(!is_null($allow)){
			if($allow){
				$disable=true;
				$disabled="";
			}
		}
	}else if($kode == 2){
		if(!is_null($guru)){
			$option="";
			foreach($guru as $value){
				$disable = true;
				$disabled = "";
				$schId = $value['identified'];
				$option .= '<option value="TEACH'.substr($schId,10,10)."".substr($schId,0,10)."".substr($schId,20,6).'">'.$value['nama'].'</option>';
			}
			$data = '<div class="form-group">
						<div class="col-sm-3">
							<label for="guru" class="control-label">Nama Guru</label>
						</div>
						<div class="col-sm-9">
							<select '.$disabled.' name="guru" class="form-control select2-list" id="guru" data-placeholder="">
								<option value="">----------------- Pilih Sekolah ---------------------</option>
								'.$option.'
							</select>
						</div>
					</div>
					';
		}else if(!is_null($allow)){
			if($allow){
				$disable=true;
				$disabled="";
			}
		}
	}else{
		$disable=true;
		$disabled="";
	}
    echo json_encode(array(
        "formTarget"=>$baseUrl."Sekolah/add.jsp",
        "header"=>$header,
        "yes"=>$disable,
        "contentForm"=> $data.'
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nip" class="control-label">Nip</label>
                </div>
                <div class="col-sm-9" id="listNip">
                    <input type="text" '.$disabled.' name="nip" id="nip" class="form-control" placeholder="Nip Wali">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="wali" class="control-label">Nama</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="wali" id="wali" class="form-control" placeholder="Nama Wali">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="col-sm-9">
                    <input type="email" '.$disabled.' name="email" id="email" class="form-control" placeholder="Email Wali">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nohp" class="control-label">No Handphone</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="nohp" id="nohp" class="form-control" placeholder="No handphone Wali">
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
    ));
?>
