var tm = "";
var timer = null;
var bingo = null
var elementId = 0;
function loadPage(url){
 
 tm = window.open(url,'rating',"width=550,height="+screen.availHeight+",left=10,top=10,scrollbars=1");
tm.focus();
   

}

//function to visit url
function visitLink(btn){
var url = btn.id;
var id = btn.value;
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function(){
 if(this.readyState == 4 && this.status == 200){
   loadPage(url);
   elementId = id;
   bingo = 1;
   timer = setInterval(checkChild,1000);
 }
}

xhttp.open("GET","visitpage?ads_id="+id,true);
xhttp.send();
}




//creating a function to close links
function closeLink(id){  
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function(){
  if(this.readyState == 4 && this.status == 200){
    document.getElementById("body").innerHTML = this.responseText;
  
   }
}

xhttp.open("GET","closepage?ads_id="+id,true);
xhttp.send();
}


//function to monitor when child window is closed
//timer = setInterval(checkChild,1000);
function checkChild(){
 if(tm.closed){
     if(bingo == 1){
     closeLink(elementId); 
     clearInterval(timer);
     bingo = 0;
     }else{
       return false;
     }
 }

}