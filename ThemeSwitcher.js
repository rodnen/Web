
document.addEventListener('DOMContentLoaded', function () {
	button = document.getElementById('changeTheme');

  button.addEventListener('click',ChangeTheme);

  if(!document.body.classList.contains('light') && !document.body.classList.contains('dark')){
    document.body.classList.add('light');
  }

  if(localStorage['theme'] == 'light'){
    document.body.classList.add('light');
    document.body.classList.remove('dark');
    button.innerHTML="<i class='bx bx-moon' ></i>"    
  }

  if(localStorage['theme'] == 'dark'){
    document.body.classList.add('dark');
    document.body.classList.remove('light');
    button.innerHTML="<i class='bx bx-sun' ></i>"    
  }
 });

function ChangeTheme(){
  console.log(document.body);
  document.body.classList.toggle("light");
  document.body.classList.toggle("dark");
  if(document.body.classList.contains('light')){
    localStorage['theme'] = 'light';
    button.innerHTML="<i class='bx bx-moon' ></i>"
  }
  else{
    localStorage['theme'] = 'dark';
    button.innerHTML="<i class='bx bx-sun' ></i>"
  }
}