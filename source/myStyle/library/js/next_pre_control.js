var NextPreVar = [];
NextPreControlClass = function(a){
	this.id = a.id;
	this.func = function(b){
		a.func(b);
	};
	this.getString = function(a){
		var j = "";
		if(a.left)
			j += '<li id="'+this.id+'_previous"><a style="cursor : pointer;">««</a></li>';
		else
			j += '<li id="'+this.id+'_previous" class="disabled"><a>««</a></li>';
		
		if(a.right)
			j += '<li id="'+this.id+'_next"><a style="cursor : pointer;">»»</a></li>';
		else
			j += '<li id="'+this.id+'_next" class="disabled"><a>»»</a></li>';
		return j;
			
	}
	NextPreVar[this.id+"_page"] = 1;
	this.getPage = function(){
		return NextPreVar[this.id+"_page"];
	};
	this.setPage = function(a){
		NextPreVar[this.id+"_page"] = parseInt(a);
	};
	this.initialize = function(a){
		var temp = this;
		
		$("#"+temp.id).html("");
		$("#"+temp.id).html(temp.getString(a));
		if(a.left){
			$("#"+temp.id+"_previous").on("click",function(){
				NextPreVar[temp.id+"_page"] -= 1;
				temp.func(temp.getPage());
			});
		}
		if(a.right){
			$("#"+temp.id+"_next").on("click",function(){
				NextPreVar[temp.id+"_page"] += 1;
				temp.func(temp.getPage());
			});
		}
		
	};
	
};