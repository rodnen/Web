/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */


document.addEventListener('DOMContentLoaded', function () {
  var button = document.getElementById("dropbtn");
  var form = document.getElementById('dropForm');
  var overlay = document.getElementById('hidelay');
  var exit = document.getElementById('back');
  var menu = document.querySelector('.menuList');
  var hideMenu = document.getElementById('hideMenu');
  var showMenu = document.getElementById('showMenu');

  //let top = window.pageYOffset;
  //let menu = document.getElementById("menu");
  //let wrapper = document.querySelector(".wrapper");

  var categories = document.getElementById('dropCategories');

  if(localStorage.getItem('hide') == 'show'){
    Show();
  }
  if(button && overlay && exit){
    button.addEventListener('click',Show);
    overlay.addEventListener('click', Hide);
    exit.addEventListener('click', Hide);
  }


  window.onclick = function(event) {
  if (!event.target.matches('.addpublic') && !event.target.matches('#addpublic') && !event.target.matches('#addp')) {
    
    var dropdowns = document.getElementsByClassName("addpublic");

    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        openDropdown.classList.add('hidden');
      }
    }
  }

  if (!event.target.matches('.profile') && !event.target.matches('#profile')) {
    
    var dropdowns = document.getElementsByClassName("profile");

    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        openDropdown.classList.add('hidden');
      }
    }
  }

  if (!event.target.matches('.categories') && !event.target.matches('#categories')) {
  
  
    var dropdowns = document.getElementsByClassName("categories");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
        openDropdown.classList.add('hidden');
      }
    }
  }

  showMenu.addEventListener('click', function(event) {
      menu.classList.add('showMenu');
      menu.classList.remove('hideMenu');
  });

  hideMenu.addEventListener('click', function(event) {
      menu.classList.remove('showMenu');
      menu.classList.add('hideMenu');
  });

  if (event.target.matches('#overlay')) {
    Search();
  }
}

})

  
function Categories() {
  document.getElementById("dropCategories").classList.toggle("show");
  document.getElementById("dropCategories").classList.toggle("hidden");
}
function AddPublic() {
  document.getElementById("dropAdd").classList.toggle("show");
  document.getElementById("dropAdd").classList.toggle("hidden");
}

function Profile() { 
  document.getElementById("dropProfile").classList.toggle("show");
  document.getElementById("dropProfile").classList.toggle("hidden");
}

function Search() {
  overlay = document.getElementById('overlay');

  document.getElementById("dropSearch").classList.toggle("show");
  document.getElementById("dropSearch").classList.toggle("hidden");
  
  overlay.classList.toggle("hidden");
  overlay.classList.toggle("show");
  
  document.body.classList.toggle('overflowY');
}




function Show(){
  document.getElementById('dropForm').classList.replace('hidden', 'show');
  document.getElementById('hidelay').classList.replace('hidden', 'show');
  localStorage.setItem('hide', 'show');
}

function Hide(){
  document.getElementById('dropForm').classList.replace('show', 'hidden');
  document.getElementById('hidelay').classList.replace('show', 'hidden');
  localStorage.setItem('hide', 'hide');
}
