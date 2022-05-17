document.addEventListener('DOMContentLoaded', function () {

	let folder = document.querySelectorAll('.type'),
    header = document.querySelector('#tabs'),
    tabContent = document.querySelectorAll('.Fcontent'); 

   
   	let content = document.querySelector('.foldersContent');
   	let Icon = document.querySelector('#Icon');
   	let Header = document.querySelector('#Header');


    function hideTabContent(x) {
	  for (let i = x; i < tabContent.length; i++) {
	    tabContent[i].classList.remove('show');
	    tabContent[i].classList.add('hidden');
	    tabContent[i].remove.id;
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
		  
		  if (target && target.classList.contains('type')) {
		    for(let i = 0; i < folder.length; i++) {
		      if (target == folder[i]) {
		        hideTabContent(0);
		        showTabContent(i);
		        folder[i].classList.remove('notactiveFolder');
		    	folder[i].classList.add('activeFolder');
		    	content = document.querySelector('.show');
		        break;
		      }
		    }
		  }
		});
	}

	if(content && !Icon && !Header){
		content.addEventListener("change", function (event) {
			let target = event.target;
			let labelImg = this.querySelector('.show').querySelector('.labelImg');
			let labelFile = this.querySelector('.show').querySelector('.labelFile');
			let image = this.querySelector('.show').querySelector('.addimage');
			let file = this.querySelector('.show').querySelector('.addfile');

		  	if (target.files[0] && image == target) {
			    var fr = new FileReader();
			    fr.addEventListener("load", function () {
			      labelImg.style.backgroundImage = "url(" + fr.result + ")";
			      labelImg.style.backgroundSize= "cover";
			      labelImg.style.backgroundPosition="center";
			    }, false);

			    fr.readAsDataURL(this.querySelector('.show').querySelector('.addimage').files[0]);
			}

			if (target.files[0] && file == target) {
			    var fr = new FileReader();
			    fr.addEventListener("load", function () {
			      labelFile.classList.add("filledFile");
			    }, false);

			    fr.readAsDataURL(this.querySelector('.show').querySelector('.addfile').files[0]);
			}
		});
	}


	if(Icon){
		Icon.addEventListener("change", function (event) {
			let target = event.target;
			let labelImg = document.querySelector('.userIcon');

			//console.log(labelImg);
		  	if (target.files[0]) {
			    var fr = new FileReader();
			    fr.addEventListener("load", function () {
			      labelImg.style.backgroundImage = "url(" + fr.result + ")";
			      labelImg.style.backgroundSize= "cover";
			      labelImg.style.backgroundPosition="center";
			    }, false);

			    fr.readAsDataURL(target.files[0]);
			}
		});
	}

	if(Header){
		Header.addEventListener("change", function (event) {
			let target = event.target;
			let labelImg = document.querySelector('.userHeader');

		  	if (target.files[0]) {
			    var fr = new FileReader();
			    fr.addEventListener("load", function () {
			      labelImg.style.backgroundImage = "url(" + fr.result + ")";
			      labelImg.style.backgroundSize= "cover";
			      labelImg.style.backgroundPosition="center";
			    }, false);

			    fr.readAsDataURL(target.files[0]);
			}
		});
	}
	
});
