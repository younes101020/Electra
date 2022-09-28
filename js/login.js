
let styleElem = document.head.appendChild(document.createElement("style"));
let firstInput = document.getElementById('finput');
let submitBtn = document.getElementById('submitt');

// Initialisation des variables global qui permettront la vérification des erreurs au submit/ 1 = erreur 0 = aucune erreur
let errorAccname;

// PHP notif

let phpnotifTl = gsap.timeline({});

phpnotifTl.to("#phpnotif", {autoAlpha: 1, y: 50});
phpnotifTl.to("#phpnotif", {autoAlpha: 0, y: 0, duration: 1}, "+=2");

const checkexistName = () => {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        console.log(this.responseText);
        if (this.readyState == 4 && this.status == 200) {
                 if(this.responseText == "false") {
                    errorAccname = 1;
                     firstInput.style.border = "solid 1px #C42021";
                     styleElem.innerHTML += '#bfinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #E20203; font-size: 1.5rem; top: 0.45rem; right: .6rem;}';
                 } else {
                    errorAccname = 0;
                     firstInput.style.border = "solid 1px #5AFF15";
                     styleElem.innerHTML += '#bfinput::before {position: absolute; font-family: FontAwesome; content: "\\f058"; color: #5AFF15; font-size: 1.5rem; top: 0.45rem; right: .6rem;}';
                 }
            }
            }
        xmlhttp.open("GET", "../controllers/indexController.php?pseudonyme=" + firstInput.value, true)
        xmlhttp.send();
    };

    firstInput.onkeyup = () => {
        checkexistName();
    }

submitBtn.addEventListener("click", (e) => {
    if(errorAccname == 0) {

    } else {
        e.preventDefault();
    }
});