function sendRequest(options){
	var http;
	try{
		http = new XMLHttpRequest();
	}
	catch(e){
		try{
			http = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
		}
	}
	http.open(options.method, options.url, options.method);
	http.onreadystatechange = function(){
		if (this.readyState == 4){
			if(this.status == 200){
				options.success(this);
			}
			else{
				options.error(this);
			}	
		}
	}
	http.send();
}
document.addEventListener('DOMContentLoaded', function () {

	let folder = document.querySelectorAll('.folder'),
    header = document.querySelector('#tabs'),
    tabContent = document.querySelectorAll('.foldersContent'),
    countofPublics = document.querySelectorAll('.countOfPublics'),
	find = document.getElementById('find');
    
    var number = window.location.search.substr(13);
   
   	if(window.location.pathname.includes('user')){
	    if (!window.location.search.substr(13))
	    	number=1;

	  	changecontent(number);
	}
 	
	function hideTabContent(x) {
	  for (let i = x; i < tabContent.length; i++) {
	    tabContent[i].classList.remove('show');
	    tabContent[i].classList.add('hidden');
	    folder[i].classList.remove('activeFolder');
	    folder[i].classList.add('notactiveFolder');
	  }
	}



	function showTabContent(y) {
	  if (tabContent[y].classList.contains('hidden')) {
	    tabContent[y].classList.remove('hidden');
	    tabContent[y].classList.add('show');
	  }
	}

	if(header){
		header.addEventListener('click', function(event) {
		  let target = event.target;
		  if (target && target.classList.contains('folder')) {
		    for(let i = 0; i < folder.length; i++) {
		      if (target == folder[i]) {
		        hideTabContent(0);
		        showTabContent(i);
		        folder[i].classList.remove('notactiveFolder');
		    	folder[i].classList.add('activeFolder');
		    	number = i+1;
		    	localStorage.setItem('number',number);
		    	changecontent(number);
		        break;
		      }
		    }
		  }
		});
	}
	
	function changecontent(number){

		var page = document.getElementById("active");
		if(page)
			page = parseInt(page.innerText);
		else{
			page = 1;
		}

	    var count = 0;
	
	   		var baseUrl = window.location.protocol + "//" + window.location.host + window.location.pathname +"?"+ window.location.search.substr(1);
	   		baseUrl = baseUrl.split('&')[0];
	   		var newUrl=baseUrl+'&folder='+number;
		    history.pushState(null, null, newUrl);
	        
		    sendRequest({
			method: 'GET',
			url: '///'+window.location.host+'/Game/action/ajaxJSON?folder='+number+'&page='+page+'&'+window.location.search.substr(1,4),
			success: function(http){
				SetCountOfPublics();
				var list = JSON.parse(http.responseText);

				var body = document.querySelectorAll(".wrapper-center");
				var paginbody = document.getElementById("pagination");
				body.innerHTML = "";
				str = "";
				count = list[0].count;

				for (var i = 0; i < list.length; i++) {
					
					string = list[i].discription;

					title = list[i].name;

					if(string.length > 43){
						string = string.substr(0, 43);
						string+='...';
					}

					if(title.length > 30){
						title = title.substr(0, 30);
						title+='...';
					}

					

					months=["січ.","лют.","бер.","кві.","трав.","чер.","лип.","сер.","вер.","жов.","лист.","груд."];
					date = list[i].date.split('-');
					year = date[0];
					month = date[1];
					day = date[2].split(' ')[0];

					edit = '';
					pictr = '';
					pg = '';
					remove = '';
					if(list[i].pub_type == 1){
						pictr = '/Game/images/newspictrs/';
						edit = '/Game/editnews?id='+list[i].id;
						pg = '/Game/news-page?id='+list[i].id;
						remove = '/Game/action/remove?id='+list[i].id+'&type=1';
					}
					if(list[i].pub_type == 2){
						pictr = '/Game/images/publicpictrs/';
						edit = '/Game/editpublic?id='+list[i].id;
						pg = '/Game/title?id='+list[i].id;
						remove = '/Game/action/remove?id='+list[i].id+'&type=2';
					}

					circles = '';

					if(mysession == window.location.search.substr(4,1)){
						circles = '<div class="circles"><a href="'+remove+'"><div class="delete"><i class="bx bx-trash" ></i></div></a><a href="'+edit+'"><div class="update"><i class="bx bx-pencil" ></i></div></a></div>';
					}
					str+='<div class="block bigblock flex"><div class="content"><a href="'+pg+'"><div class="picture"><img src="'+pictr+list[i].image+'">'+circles+'</div></a><div class="discription flex"><div class="title"><b><span>'+title+'</span></b></div><div class="line"><span>'+string+'</span></div><div class="pinfo flex"><span class="info flex"><span class="likes"><i class="bx bx-heart"></i><span>'+list[i].likes+'</span></span><span class="likes"><i class="bx bx-comment" ></i><span>'+list[i].coments+'</span></span></span><span class="date">'+day+' '+months[month-1]+' '+year+'р'+'</div></div></div></div>';
				}
				body[number].innerHTML=str;
				paginbody.innerHTML=Pagination(count);
			},
			error: function(http){
				console.log('ERROR');
			}
		});
		}


	function SetCountOfPublics(){
		for(let i = 0; i<folder.length; i++){
			sendRequest({
				method: 'GET',
				url: '///'+window.location.host+'/Game/action/ajaxJSON?folder='+(i+1)+'&'+window.location.search.substr(1,4),
				success: function(http){
					var content = JSON.parse(http.responseText);
					if(http.responseText.length > 2){
						count = content[0].count;
						countofPublics[i].innerText=count;
					}
					else{

						countofPublics[i].innerText=0;
					}
				},
					error: function(http){
					console.log('ERROR');
				}
			});
	}
}

if(find){
	find.addEventListener('change',(event) => {  
		name = event.target.value;
		 sendRequest({
			method: 'GET',
			url: '///'+window.location.host+'/Game/action/ajaxJSON?find='+name,
			success: function(http){
				var list = JSON.parse(http.responseText);
				var finded = document.querySelector("#finded");
				var body = document.querySelector("#publics");
				body.innerHTML = "";
				finded.classList.remove('hidden');
				str = "";
				for (var i = 0; i < list.length; i++) {
					string = list[i].discription;
					title = list[i].name;
					if(string.length > 43){
						string = string.substr(0, 43);
						string+='...';
					}
					if(title.length > 30){
						title = title.substr(0, 30);
						title+='...';
					}

					months=["січ.","лют.","бер.","кві.","трав.","чер.","лип.","сер.","вер.","жов.","лист.","груд."];
					date = list[i].date.split('-');
					year = date[0];
					month = date[1];
					day = date[2].split(' ')[0];

					edit = '';
					pictr = '';
					pg = '';
					remove = '';
					
					if(list[i].pub_type == 1){
						
						pictr = '///'+window.location.host+'/Game/images/newspictrs/';
						edit = '/Game/editnews?id='+list[i].id;
						pg = '/Game/news-page?id='+list[i].id;
						remove = '/Game/editnews?id='+list[i].id+'&type=1';
					}
					if(list[i].pub_type == 2){
						pictr = '///'+window.location.host+'/Game/images/publicpictrs/';
						
						edit = '/Game/editpublic?id='+list[i].id;
						pg = '/Game/title?id='+list[i].id;
						remove = '/Game/editnews?id='+list[i].id+'&type=2';
					}
					circles = '';

					str+='<div class="block bigblock flex"><div class="content"><a href="'+pg+'"><div class="picture"><img src="'+pictr+list[i].image+'">'+circles+'</div></a><div class="discription flex"><div class="title"><b><span>'+title+'</span></b></div><div class="line"><span>'+string+'</span></div><div class="pinfo flex"><span class="info flex"><span class="likes"><i class="bx bx-heart"></i><span>'+list[i].likes+'</span></span><span class="likes"><i class="bx bx-comment" ></i><span>'+list[i].coments+'</span></span></span><span class="date">'+day+' '+months[month-1]+' '+year+'р'+'</div></div></div></div>';
					}
					body.innerHTML=str;

					if(http.responseText.length == 2){
						body.innerHTML='<span style="font-size:15px;">Нічого не знайдено</span>';	
					}
				},
				error: function(http){
					console.log('ERROR');
				}
			});
		
	});
}


	function Pagination(count){
		var pagin = "";
		var page = 1;

		if (window.location.search.indexOf('page') > -1)
		{
	  		page = window.location.search.replace('?','').replace('page=','').replace('&','');
		}
		
		var pages = Math.ceil(count/8);
		var limitPages = 5;
		var first = page - Math.round(limitPages / 2);
		
		if (first < 1) first = 1;
		
		var last = first + limitPages - 1;
		var next = parseInt(page) + 1;
	    var pre = page -1;
		
		var n = "<i class='bx bx-chevron-right'></i>";
	    var p = "<i class='bx bx-chevron-left'></i>";
	    var arrow_l = "<i class='bx bx-chevrons-left'></i>";
	    var arrow_r = "<i class='bx bx-chevrons-right'></i>";

	    if (last > pages) {
	            last = pages;
	            first = last - limitPages + 1;
	            if (first < 1) first = 1;
	        }
	        if(page>1){
	            pagin +="<a href=?page=1&>"+arrow_l+"</a>"+"<a href=?page="+pre+"&>"+p+"</a>";
	        }

	        for(var i=first; i <= last; i++) {

	            if (i == page) {
	                pagin += "<a id='active' class='active'>"+i+"</a>";
	            }else {
	                pagin += "<a href='?page="+i+"&'>"+i+"</a>";
	            }
	        }
	        if (last != page && last > page) {
	            pagin +="<a href=?page="+next+"&>"+n+"</a>"+" <a href=?page="+pages+"&>"+arrow_r+"</a>";
	        }
	        
	        return pagin;
	}
});