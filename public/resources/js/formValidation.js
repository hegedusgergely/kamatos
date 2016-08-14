function validateForm() {

    var loanValue = document.getElementById("loan").value;

    var interestValue = document.getElementById("interest").value;

    var durationValue = document.getElementById("duration").value;


    if (loanValue == null || loanValue == "") {
        alert("A tőke mező nem lehet üres!");
        return false;
    }

    if (interestValue == null || interestValue == "") {
        alert("A kamat mező nem lehet üres!");
        return false;
    }

    if (durationValue == null || durationValue == "") {
        alert("A futamidő mező nem lehet üres!");
        return false;
    }

}

function loanTextLiveUpdate() {

    loanValue.toLocaleString();

}
