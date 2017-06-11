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
			if($disGuru){
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
			}else{
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
			}
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
								<option value="">----------------- Pilih Nama Guru ---------------------</option>
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
                    <label for="judul" class="control-label">Judul</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="judul" id="judul" class="form-control" placeholder="Judul">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="deskripsi" class="control-label">deskripsi</label>
                </div>
                <div class="col-sm-9">
                    <textarea style="resize : none; height : 200px;" type="text" '.$disabled.' name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="kategori" class="control-label">Status</label>
                </div>
                <div class="col-sm-9">
                    <select '.$disabled.' name="kategori" id="kategori" class="form-control" >
						<option value="1" selected> still plan </option>
						<option value="2"> doing of plan </option>
						<option value="3"> delay of plan </option>
						<option value="4"> dismiss of plan </option>
						<option value="5"> finish of plan </option>
					</select>
                </div>
            </div>
        '
    ));
?>
