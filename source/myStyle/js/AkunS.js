AkunControlClass = function(){
    this.getCoul = function(disable){
        var a = this;
        if(defaultPage == 2){
            var e = new jaservAjax({
                url : prefixUrl+'Globe/getCoulumn.jsp',
                targetPath : prefixUrl+"",
                codeReloadToTargetPath : '&',
                codeReloadFuncTrue : '0',
                codeReloadFuncFalse : '6',
                reloadFunc : false,
                content : "kodeExit=J453RVT3CH_W3N4",
                funcTrue : function(message){
                    var x = JSON.parse(message);
                    $("#inf-num-all").html(x.all);
                    $("#inf-num-tea").html(x.guru);
                    $("#inf-num-par").html(x.wali);
                    if(disable)
                        setTimeout(function(){a.getCoul()},5000);
                    //loading.setMessage(message+'...').close();
                },
                funcFalse : function(message){
                    a.getCoul();
                    //loading.setMessage(message+'...').close();
                },
                funcAlternate : function(message){
                    //loading.setMessage(message+'...').close();
                },
                funcProcess : function(message){
                    //loading.setMessage('process ...');
                }
            });
            e.postTrue();
        }
    };
    this.getData = function(){

    };
    this.getDataLastView = function(){

    };
    this.viewProfile = function(){

    };
    this.initialize = function(){
        if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK > 2)
            this.pressingButtonSerach = 4;
        else
            this.pressingButtonSerach = 1;
		VarMembeContentPreNext = new NextPreControlClass({
			id : "next-pre-member-content",
			func : function(a){
				AkunControl.getMidTemp(false,a);
			}
		});
		$(".tag-action").on('click',function(){
			var xyx = this;
			$(".tag-action").removeClass("active");
			$(this).addClass('active');
			a = this;
			$("#search-member").val("");
			AkunControl.key = "";
			AkunControl.pressingButtonSerach = a.getAttribute('kode');
			VarMembeContentPreNext.setPage(1);
			AkunControl.getMidTemp(false,1);
		});
        this.getCoul(true);
        this.getMidTemp(true,1);
        $("#sch-id-list-member").on('change',function(){
			$(".tag-action").removeClass("active");
			var xyx = document.getElementsByClassName('tag-action');
			$(xyx[0]).addClass('active');
			AkunControl.pressingButtonSerach = 1;
			AkunControl.option = $('#sch-id-list-member').val();
			AkunControl.getCoul(false);
			AkunControl.getMid(AkunControl.key);
        });
    };
    this.getMid = function(keyword){
		AkunControl.key = keyword;
        VarMembeContentPreNext.setPage(1);
        AkunControl.getMidTemp(false,1);
    };
    this.getOneContact = function(a){
        return '<div class="col-xs-12 col-lg-6 hbox-xs" style="cursor : pointer" onclick="alert()">'+
            '<div class="hbox-column width-2">'+
                '<img class="img-circle img-responsive pull-left" src="source/assets/img/avatar9.jpg?1404026744" alt="" />'+
            '</div>'+
            '<div class="hbox-column v-top">'+
                '<div class="clearfix">'+
                    '<div class="col-lg-12 margin-bottom-lg">'+
                        '<a class="text-lg text-medium" onclick="AkunControl.showProfile();">'+a.name+'</a>'+
                    '</div>'+
                '</div>'+
                '<div class="clearfix opacity-75">'+
                    '<div class="col-md-5">'+
                        '<span class="glyphicon glyphicon-phone text-sm"></span> &nbsp;'+a.notelp+
                    '</div>'+
                    '<div class="col-md-7">'+
                        '<span class="glyphicon glyphicon-envelope text-sm"></span> &nbsp;'+a.email+
                    '</div>'+
                '</div>'+
                '<!--<div class="clearfix">'+
                    '<div class="col-lg-12">'+
                        '<span class="opacity-75"><span class="glyphicon glyphicon-map-marker text-sm"></span> &nbsp;795 Folsom Ave, San Francisco, CA 94107</span>'+
                    '</div>'+
                '</div>-->'+
                '<div class="stick-top-right small-padding">'+
                    '<i class="fa fa-dot-circle-o fa-fw text-success" data-toggle="tooltip" data-placement="left" data-original-title="User online"></i>'+
                '</div>'+
            '</div>'+
        '</div>';
    };
	//fix
    this.getMidTemp = function(disable,page){
        var a = this;
        console.log({xx : a.option, yy : a.pressingButtonSerach,kk:a.key});
       // alert(a.page);
          if(defaultPage == 2){
			  if(a.option == "ALL") tempUrl = ".jsp";
			  else tempUrl = "/"+a.option+".jsp";
            var e = new jaservAjax({
                url : prefixUrl+'Globe/getListItem'+tempUrl,
                targetPath : prefixUrl+"",
                codeReloadToTargetPath : '&',
                codeReloadFuncTrue : '0',
                codeReloadFuncFalse : '6',
                reloadFunc : false,
                content : "kodeExit=J453RVT3CH_W3N4&key="+a.key+"&kode="+a.pressingButtonSerach+"&keypage="+page,
                funcTrue : function(message){
                    var z = JSON.parse(message);
					//alert(z.next+" "+z.previous);
					next = false;
					if(z.next == 1)
						next = true;
					previous = false;
					if(z.previous == 1)
						previous = true;
					VarMembeContentPreNext.initialize({
						right : next,
						left : previous 
					});
                    if(z.data.name){
                        var temp = "";
                        for(i=0;i<z.data.name.length;i++){
                            temp += a.getOneContact({
                                name : z.data.name[i],
                                notelp : z.data.notelp[i],
                                email : z.data.email[i]
                            });
                        }
                        $('#total-member-result').html(z.result);
                        $("#list-of-view-member").html(temp); 
                    }else{
                        $('#total-member-result').html(0);
                        $("#list-of-view-member").html("not found");
                    }
                    //console.log(message);
                   // $("#sch-id-list-member").val(a.option);
                   if(disable)
                    setTimeout(function(){a.getMidTemp(disable);},30000);
                    //loading.setMessage(message+'...').close();
                },
                funcFalse : function(message){
                    a.getCoul();
                    //loading.setMessage(message+'...').close();
                },
                funcAlternate : function(message){
                    //loading.setMessage(message+'...').close();
                },
                funcProcess : function(message){
                    //loading.setMessage('process ...');
                }
            });
            e.postTrue();
        }
    };
    this.showProfile = function(id){
        $("#add_member").fadeIn('slow');
        $("#back_to_the_list").fadeOut('slow');
    };
    this.top = false;
    this.previous = false;
    this.next = false;
    this.bottom = false;
    this.page = 1;
    this.tryTop = function(){
        if(!this.top) return;
        alert();
    };
    this.tryPrevious = function(){
        if(!this.previous) return;
        AkunControl.page--;
        this.getMidTemp(false);
    };
    this.tryNext = function(){
        if(!this.next) return;
        AkunControl.page++;
        this.getMidTemp(false);
    };
    this.tryBottom = function(){
        if(!this.bottom) return;
        alert();
    };
    
    this.tempMiddle = false;
    this.key = "";
    
    this.option = "ALL";
    this.pressingButtonSerach = 1;
    this.resetMiddleTemp = function(){
        
    };
    this.addNewStackOfMiddle = function(){
        
    };
    this.pushNewStack = function(){
        
    };
}
var VarMembeContentPreNext = null;
var AkunControl = new AkunControlClass();