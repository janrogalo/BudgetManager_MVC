let start = document.getElementById("date_start").value;
let finish = document.getElementById("date_end").value;

const now = new Date();



function setDates(){
    let number = document.getElementById("range").value;




 if (number == 1 ) {

     document.getElementById("date_start").value= new Date(now.getFullYear(), now.getMonth(), 1).toISOString().slice(0, 10);
     document.getElementById("date_end").value= new Date(now.getFullYear(), now.getMonth()+ 1, 1).toISOString().slice(0, 10);
     document.form.submit();
 }
else if(number == 2){

     document.getElementById("date_start").value = new Date(now.getFullYear(), now.getMonth()-1, 1).toISOString().slice(0, 10);
     document.getElementById("date_end").value = new Date(now.getFullYear(), now.getMonth() , 1).toISOString().slice(0, 10);
     document.form.submit();


 }
 else if(number == 3){

   start = document.getElementById("date_start").value;
   finish = document.getElementById("date_end").value;
     console.log('3');

 }
}


function sendForm(){
 document.form.submit();
}
