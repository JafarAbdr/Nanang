/*
Filename : Login.js
Create : 5/4/2017
Creator : Jafar Abdurrahman Albasyir
Description : Message Control, like Toast on android
*/
//first initial
$(document).ready(function(){
	
});
//function support
ToasterControlClass = function(){
	/*
	{
		message = string/ html,
		clear = bool,
		timeOut = number
	}
	*/
	this.initState = function(){
		toastr.options.closeButton = false;
		toastr.options.progressBar = false;
		toastr.options.debug = false;
		toastr.options.positionClass = 'toast-bottom-left';
		toastr.options.showDuration = 333;
		toastr.options.hideDuration = 333;
		toastr.options.extendedTimeOut = 4000;
		toastr.options.showEasing = 'swing';
		toastr.options.hideEasing = 'swing';
		toastr.options.showMethod = 'slideDown';
		toastr.options.hideMethod = 'slideUp';
	};
	this.openSuccessMessage = function(a){
		message = "ini pesan standard";
		timeOut = 0;
		clear = false;
		if(a){
			if(a.message)
				message = a.message;
			if(a.clear)
				this.clear();
			if(a.timeOut)
				timeOut = parseInt(a.timeOut);
		}
		this.initState();
		toastr.options.timeOut = timeOut;
		toastr.success(message, '');
	};
	this.openErrorMessage = function(a){
		message = "ini pesan standard";
		timeOut = 0;
		clear = false;
		if(a){
			if(a.message)
				message = a.message;
			if(a.clear)
				this.clear();
			if(a.timeOut)
				timeOut = parseInt(a.timeOut);
		}
		this.initState();
		toastr.options.timeOut = timeOut;
		toastr.error(message, '');
	};
	this.openWarningMessage = function(a){
		message = "ini pesan standard";
		timeOut = 0;
		clear = false;
		if(a){
			if(a.message)
				message = a.message;
			if(a.clear)
				this.clear();
			if(a.timeOut)
				timeOut = parseInt(a.timeOut);
		}
		this.initState();
		toastr.options.timeOut = timeOut;
		toastr.warning(message, '');
	};
	this.openInfoMessage = function(a){
		message = "ini pesan standard";
		timeOut = 0;
		clear = false;
		if(a){
			if(a.message)
				message = a.message;
			if(a.clear)
				this.clear();
			if(a.timeOut)
				timeOut = parseInt(a.timeOut);
		}
		this.initState();
		toastr.options.timeOut = timeOut;
		toastr.info(message, '');
	};
	this.clear = function(){
		toastr.clear();
	};
};
var ToasterControl = new ToasterControlClass();