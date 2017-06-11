<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    echo json_encode(array(
        "formTarget"=>$baseUrl."Setting/update.jsp",
        "header"=>$header,
        "yes"=>false,
        "contentForm"=>'
		
			<div class="form-group">
                <div class="col-sm-12">
                    <label style="font-weight : bolder" class="control-label">Data Sekolah</label>
                </div>
			</div>
			
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="kodes" class="control-label">Kode</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="kodes" id="kodes" value="'.$dataContentS->getKode().'" class="form-control" placeholder="Kode nasional sekolah">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="namas" class="control-label">Nama</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="namas" id="namas" value="'.$dataContentS->getNama().'" class="form-control" placeholder="Nama Sekolah">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="alamats" class="control-label">Alamat</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="alamats" id="alamats" value="'.$dataContentS->getAlamat().'" class="form-control" placeholder="Alamat Sekolah">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="emails" class="control-label">Email</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="emails" id="emails" value="'.$dataContentS->getEmail().'" class="form-control" placeholder="Email Sekolah">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-3">
                    <label for="nohps" class="control-label">No Hp</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="nohps" id="nohps" value="'.$dataContentS->getNoHp().'" class="form-control" placeholder="No Handphone Sekolah">
                </div>
            </div>
			<div class="form-group">
                <div class="col-sm-12">
                    <label  style="font-weight : bolder" class="control-label">Data Kepala Sekolah</label>
                </div>
			</div>
			
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nama" class="control-label">Nama</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="nama" id="nama" value="'.$dataContent->getNama().'" class="form-control" placeholder="Nama">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nip" class="control-label">Nip</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="nip" id="nip" value="'.$dataContent->getNip().'" class="form-control" placeholder="Nip">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="col-sm-9">
                    <input type="email" disabled="true" name="email" id="email" value="'.$dataContent->getEmail().'" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nohp" class="control-label">No Handphone</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="nohp" id="nohp" value="'.$dataContent->getNoHp().'" class="form-control" placeholder="No handphone">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="idline" class="control-label">ID Line</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" disabled="true" name="idline" id="idline" value="'.$dataContent->getIdLine().'" class="form-control" placeholder="ID Line">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="ubahProfile"> Ubah
                        </label>
                    </div>
                </div>
            </div>
        '
    ))
?>
