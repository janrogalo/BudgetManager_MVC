function setStartDate() {
   const currentDate =  new Date();
    let y = currentDate.getFullYear();
    let m = currentDate.getMonth() + 1;
    if(m<10) m = '0'+m;
    d = currentDate.getDate();
    if(d<10) d = '0'+d;

    return y + "-" + m + "-" + d
}

document.querySelector('#date').value = setStartDate();