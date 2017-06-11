var ModalControlVariabelGlobal = [];
var ModalControlFunctionGlobal = [];
ModalControlVariabelGlobal['tempFormModal']="";
ModalControlClass = function(){
    this.initialOpenFormModal=function(){
        $("#formModalButtonYes").click(function(){
            ModalControlVariabelGlobal.modalFormButtonYes();
        });
    };
	this.closeFormModal = function(){
		$("#formModal").modal('hide');
	}
	this.openListModal = function(label, struk){
		if(typeof label === 'undefined') return false;
		$("#listModalLabel").html(label);
		htmlRest = "";
		i=1;
		while(typeof struk[i] !== 'undefined'){
			ModalControlFunctionGlobal[i] = struk[i].act;
			htmlRest += '<li class="tile"  style="cursor:pointer"  data-dismiss="modal" aria-hidden="true" onclick="ModalControlFunctionGlobal['+i+']()">'+
							'<a class="tile-content ink-reaction">'+
								'<div  style="padding-top : 0px;" class="tile-icon">'+
									'<i class="'+struk[i].ico+'"></i>'+
								'</div>'+
								'<div class="tile-text">'+
									struk[i].nama+
								'</div>'+
							'</a>'+
						'</li>';
			i++;
		}
		htmlRest += '<li class="tile"  style="cursor:pointer"  data-dismiss="modal" aria-hidden="true">'+
							'<a class="tile-content ink-reaction">'+
								'<div style="padding-top : 0px;"  class="tile-icon">'+
									'<i class="md md-cancel"></i>'+
								'</div>'+
								'<div class="tile-text">'+
									'Batalkan'+
								'</div>'+
							'</a>'+
						'</li>';
		$("#listModalCard").html(htmlRest);
		$('#listModal').modal({backdrop : 'static'});
	};
	this.closeFlushModal = function(){
		$("#formFlush").modal('hide');
	};
	this.openFlushModal = function(url,init,string){
        if(typeof url === 'undefined') return false;
        if(typeof string === 'undefined') return false; 
        if(typeof init !== 'function') init = function(){};
		ModalControlVariabelGlobal.modalFlushInit = function(){
            init();
        };
		ModalControlVariabelGlobal.modalFlushString = string;
		ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
		 var e = new jaservAjax({
			url : prefixUrl+url+'.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4@FORM&"+ModalControlVariabelGlobal.modalFlushString,
			funcTrue : function(message){
				ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 1000});
                //alert(message);
				//message = JSON.parse(message);
                //$("#formFlushLabel").html(message.header);
                $("#formFlushBody").html(message);
                $("#formFlush").modal({backdrop : 'static'});
                ModalControlVariabelGlobal.modalFlushInit();
                FormControl.initialize();
			},
			funcFalse : function(message){
				ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 1000});
			},
			funcAlternate : function(message){
				ToasterControl.openWarningMessage({	message : message+"...",clear : true});
			},
			funcProcess : function(message){
				ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
			}
		});
		e.postTrue();
	}
    this.openFormModal = function(url,init,yes){
        if(typeof url === 'undefined') return false;
        if(typeof init !== 'function') init = function(){};
        if(typeof yes !== 'function') yes = function(){};
        ModalControlVariabelGlobal.modalFormInit = function(){
            init();
        };
        ModalControlVariabelGlobal.modalFormButtonYes = function(){
            yes();
        };
        ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
        var e = new jaservAjax({
			url : prefixUrl+url+'.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4@FORM&"+ModalControlVariabelGlobal['tempFormModal'],
			funcTrue : function(message){
				ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 1000});
                message = JSON.parse(message);
                $("#formModalLabel").html(message.header);
                $("#formModalBody").html(message.contentForm);
                $("#formModalForm").attr("action",message.formTarget);
                if(message.yes) $('#formModalButtonYes').removeAttr("disabled");
                else $('#formModalButtonYes').attr("disabled","true");
                $("#formModal").modal({backdrop : 'static'});
                ModalControlVariabelGlobal.modalFormInit();
                FormControl.initialize();
			},
			funcFalse : function(message){
				ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 1000});
			},
			funcAlternate : function(message){
				ToasterControl.openWarningMessage({	message : message+"...",clear : true});
			},
			funcProcess : function(message){
				ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
			}
		});
		e.postTrue();
    };
};
var ModalControl = new ModalControlClass();