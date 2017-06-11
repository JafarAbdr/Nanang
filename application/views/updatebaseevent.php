<?php
$tempOption = "";
switch($data->getStatus()){
	case 1 : 
	$tempOption = '<option value="1" selected> still plan </option>
					<option value="2"> doing of plan </option>
					<option value="3"> delay of plan </option>
					<option value="4"> dismiss of plan </option>
					<option value="5"> finish of plan </option>';
	break;
	case 2 : 
	$tempOption = '<option value="1"> still plan </option>
					<option value="2" selected> doing of plan </option>
					<option value="3"> delay of plan </option>
					<option value="4"> dismiss of plan </option>
					<option value="5"> finish of plan </option>';
	break;
	case 3 : 
	$tempOption = '<option value="1"> still plan </option>
					<option value="2"> doing of plan </option>
					<option value="3" selected> delay of plan </option>
					<option value="4"> dismiss of plan </option>
					<option value="5"> finish of plan </option>';
	break;
	case 4 : 
	$tempOption = '<option value="1"> still plan </option>
					<option value="2"> doing of plan </option>
					<option value="3"> delay of plan </option>
					<option value="4" selected> dismiss of plan </option>
					<option value="5"> finish of plan </option>';
	break;
	case 5 : 
	$tempOption = '<option value="1"> still plan </option>
					<option value="2"> doing of plan </option>
					<option value="3"> delay of plan </option>
					<option value="4"> dismiss of plan </option>
					<option value="5" selected> finish of plan </option>';
	break;
}
$id='MESSAGE'.substr($data->getIdentified(),10,10)."".substr($data->getIdentified(),0,10)."".substr($data->getIdentified(),20,6);
echo json_encode(array(
        "formTarget"=>$baseUrl."Sekolah/add.jsp",
        "header"=>$header,
        "yes"=>$disable,
        "contentForm"=> '
			<input id="id" type="text" style="display : none;" name="judul" class="form-control" value="'.$id.'">
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="judul" class="control-label">Judul</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" '.$disabled.' name="judul" id="judul" class="form-control" placeholder="Judul" value="'.$data->getTitle().'">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="deskripsi" class="control-label">deskripsi</label>
                </div>
                <div class="col-sm-9">
                    <textarea style="resize : none; height : 200px;" value="'.$data->getDeskripsi().'" type="text" '.$disabled.' name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi">'.$data->getDeskripsi().'</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="kategori" class="control-label">Status</label>
                </div>
                <div class="col-sm-9">
                    <select '.$disabled.'  value="'.$data->getStatus().'" name="kategori" id="kategori" class="form-control" >
						'.$tempOption.'
					</select>
                </div>
            </div>
        '
    ));
	?>