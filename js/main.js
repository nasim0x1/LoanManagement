function print_table(divID) {

    document.getElementById("list_filter").style.display = "none";
    document.getElementById("list_paginate").style.display = "none";
    document.getElementById("list_length").style.display = "none";
    document.getElementById("list_info").style.display = "none";
    
    var printContents = document.getElementById(divID).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();

    document.getElementById("list_filter").style.display = "block";
    document.getElementById("list_paginate").style.display = "block";
    document.getElementById("list_length").style.display = "block";
    document.getElementById("list_info").style.display = "block";

}
function print_content(divID) {
    var printContents = document.getElementById(divID).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}



var elem = document.documentElement;
function FullScreeen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

function CloseFullScreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
}


    
    