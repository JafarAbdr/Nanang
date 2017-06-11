/*
Filename : Login.js
Create : 5/4/2017
Creator : Jafar Abdurrahman Albasyir
Description : Login support, login control
*/
//first initial
$(document).ready(function(){
	$('#tryLogin').click(function(){
		disableFormLogin();
		var password = $('#password').val();
		var username = $('#username').val();
		if(username == "") { ToasterControl.openWarningMessage({	message : "Kode pengguna harus diisi",	clear : true}); enableFormLogin();return;}	
		if(username.length < 3) { ToasterControl.openWarningMessage({	message : "Kode pengguna minimal 3 karakter",	clear : true}); enableFormLogin();return;}	
		if(username.length > 32) { ToasterControl.openWarningMessage({	message : "Kode pengguna maksimal 32 karakter",	clear : true}); enableFormLogin();return;}	
		if(password == "") { ToasterControl.openWarningMessage({	message : "Kata kunci harus diisi",	clear : true}); enableFormLogin();return;}	
		if(password.length < 8) { ToasterControl.openWarningMessage({	message : "Kata kunci minimal 8 karakter",	clear : true}); enableFormLogin();return;}	
		if(password.length > 32) { ToasterControl.openWarningMessage({	message : "Kata kunci maksimal 32 karakter",	clear : true}); enableFormLogin();return;}	
		var e = new jaservAjax({
			url : prefixUrl+'Login/tryValidate.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeLogin=J453RVT3CH@W3N4@L0G1N&userName="+username+"&passWord="+password,
			funcTrue : function(message){
				ToasterControl.openSuccessMessage({	message : message+"...",clear : true}); enableFormLogin();
			},
			funcFalse : function(message){
				ToasterControl.openErrorMessage({	message : message+"...",clear : true}); enableFormLogin();
			},
			funcAlternate : function(message){
				ToasterControl.openWarningMessage({	message : message+"...",clear : true}); enableFormLogin();
			},
			funcProcess : function(message){
				ToasterControl.openWarningMessage({	message : "memproses...",clear : true}); enableFormLogin();
			}
		});
		e.postTrue();
		/* ToasterControl.openWarningMessage({
			message : "coba",
			clear : true
		}); */
	});
});
//function support
function disableFormLogin(){
	$("#username").attr("disabled","true");
	$("#password").attr("disabled","true");
	$("#stayIn").attr("disabled","true");
	$("#tryLogin").attr("disabled","true");
}
function enableFormLogin(){
	$("#username").removeAttr("disabled");
	$("#password").removeAttr("disabled");
	$("#stayIn").removeAttr("disabled");
	$("#tryLogin").removeAttr("disabled");
}