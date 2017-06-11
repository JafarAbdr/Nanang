var MainLayoutVariabel = 1;
MainLayoutClass = function(){
	//this.layout = 1;
	this.open = function(){
		MainLayoutVariabel = 1;
		$('#other-layout').slideUp('slow',function(){
			$('#other-layout').html("");
			$('#dashboard-layout').slideDown('slow');
		});
	};
	this.close = function(tempHTML,initial){
		if(initial == 'undefined' || initial == null) initial = function(){};
		MainLayoutVariabel = 2;
		$('#dashboard-layout').slideUp('slow',function(){
			$('#other-layout').html(tempHTML);
			$('#other-layout').slideDown('slow',function(){
				initial();
			});
		});
	};
	this.reload = function(tempHTML,initial){
		if(initial == 'undefined' || initial == null) initial = function(){};
		if(MainLayoutVariabel == 1){
			$('#dashboard-layout').slideUp('slow',function(){
				$('#dashboard-layout').slideDown('slow',function(){
					initial();
				});
			});
		}else{
			$('#other-layout').slideUp('slow',function(){
				$('#other-layout').html(tempHTML);
				$('#other-layout').slideDown('slow',function(){
					initial();
				});
			});
		}
	};
}
var MainLayout = new MainLayoutClass();