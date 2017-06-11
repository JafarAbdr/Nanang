<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    echo json_encode(array(
        "formTarget"=>$baseUrl."Setting/update.jsp",
        "header"=>$header,
        "yes"=>false,
        "contentForm"=>'
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
