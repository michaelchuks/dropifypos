//function to delete question
function deleteQuestion(element){
    var id = element.id;
    var k = confirm("Do You Want To Delete Question " + id);
    if(k == false){
        return false;
    }else{
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                location.href="questions";
            }
        }

        xhttp.open("GET","deletequestion?question_id="+id,true);
        xhttp.send();
    }
}

//function to copy coupon code
function copyCode(id,element){
    var r = document.createRange();
    r.selectNode(document.getElementById(id));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(r);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    var button = document.getElementById(element);
    button.innerHTML = "code Copied";
    button.disabled = true;
}

function copyCodeMax(btn){
    var button = btn.id;
    var code = button.slice(1);
    var r = document.createRange();
    r.selectNode(document.getElementById(code));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(r);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    var element = document.getElementById(button);
    element.innerHTML = "Code Copied";
    element.disabled = true;
}