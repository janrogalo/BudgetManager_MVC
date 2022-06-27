const modal = document.getElementById("myModal");
const btn = document.getElementById("modalTrig");
const span = document.getElementsByClassName("close")[0];
const returnBtn = document.querySelector(".return");
const keepAdding = document.querySelector(".addExpense");



btn.onclick = function() {
    modal.classList.toggle('displayNone')

}
span.onclick = function() {
    modal.classList.toggle('displayNone')
}

returnBtn.onclick = function() {
    modal.classList.toggle('displayNone')
}

keepAdding.onclick = function() {
    modal.classList.toggle('displayNone')
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.classList.toggle('displayNone')
    }
}