<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    echo json_encode(array(
        "formTarget"=>$baseUrl."Sekolah/add.jsp",
        "header"=>$header,
        "yes"=>true,
        "contentForm"=>'
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nama" class="control-label">Nama</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="kepsek" class="control-label">Kepala Sekolah</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="kepsek" id="kepsek" class="form-control" placeholder="Nama Kepala Sekolah">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nip" class="control-label">Nip</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Nip Kepala Sekolah">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="email" class="control-label">Email</label>
                </div>
                <div class="col-sm-9">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Kepala Sekolah">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="nohp" class="control-label">No Handphone</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="nohp" id="nohp" class="form-control" placeholder="No handphone Kepala Sekolah">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3">
                    <label for="idline" class="control-label">ID Line</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" name="idline" id="idline" class="form-control" placeholder="ID Line">
                </div>
            </div>
        '
    ))
?>
