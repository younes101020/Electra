let styleElem = document.head.appendChild(document.createElement("style"));

        // element dom de la page inscription

        let errorPass = window.getComputedStyle(document.getElementById('btinput'), '::before');
        let errorMail = window.getComputedStyle(document.getElementById('bsinput'), '::before');
        let errorUser = window.getComputedStyle(document.getElementById('bfinput'), '::before');

        let firstInput = document.getElementById('finput');
        let mailInput = document.getElementById('sinput');
        let passInput = document.getElementById('tinput');

        // Initialisation des variables global qui permettront la vérification des erreurs au submit/ 1 = erreur 0 = aucune erreur
        let errorAccname;
        let errorAccmail;
        let errorAccpass;

        // Les deux prochaines fonctions ont nécessiter AJAX car je souhaite vérifier des données php en javascript
        // Deux vérifications ont été faites: La regex et la vérification de donnée déjà existante

        const checkexistName = () => {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                            if(this.responseText != "false") {
                                errorAccname = 1;
                                firstInput.style.border = "solid 1px #C42021";
                                styleElem.innerHTML += '#bfinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #E20203; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                            } else if(!/^[A-Za-z]{5,10}.{0,4}$/.test(firstInput.value)) {
                                errorAccname = 1;
                                firstInput.style.border = "solid 1px #E20203";
                                styleElem.innerHTML += '#bfinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #C42021; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                            } else {
                                errorAccname = 0;
                                firstInput.style.border = "solid 1px #5AFF15";
                                styleElem.innerHTML += '#bfinput::before {position: absolute; font-family: FontAwesome; content: "\\f058"; color: #5AFF15; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                            }
                        }
                        }
                    xmlhttp.open("GET", "../controllers/indexController.php?pseudonyme=" + firstInput.value, true)
                    xmlhttp.send();
                };

                const checkexistMail = () => {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                                errorAccmail = 1;
                                console.log(this.responseText)
                                if(this.responseText != "false") {
                                    mailInput.style.border = "solid 1px #C42021";
                                    styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #E20203; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                                } else if(!/(.+)@(.+){2,}\.(.+){2,}/.test(mailInput.value)) {
                                    errorAccmail = 1;
                                    mailInput.style.border = "solid 1px #E20203";
                                    styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #C42021; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                                } else {
                                    errorAccmail = 0;
                                    mailInput.style.border = "solid 1px #5AFF15";
                                    styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f058"; color: #5AFF15; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                                }
                            }
                            }
                        xmlhttp.open("GET", "../controllers/indexController.php?email=" + mailInput.value, true)
                        xmlhttp.send();
                    };

                firstInput.onkeyup = () => {
                    checkexistName();
                }

                mailInput.onkeyup = () => {
                    checkexistMail();
                }

        // Cette fonction ne nécessite aucune données PHP car nous ne devons et pouvons pas vérifier ce genre de données SQL

        const checkRegex = (input) => {
            if(input.getAttribute('type') === "password") {
                    if(/[A-Z]{1,5}[a-z]{1,5}(?=.*[0-9]{1,5})(?=.*[^\w\d]{1,5})/.test(input.value)) {
                        errorAccpass = 0;
                        passInput.style.border = "solid 1px #5AFF15";
                        styleElem.innerHTML += '#btinput::before {position: absolute; font-family: FontAwesome; content: "\\f058"; color: #5AFF15; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                    } else {
                        errorAccpass = 1;
                        passInput.style.border = "solid 1px #C42021";
                        styleElem.innerHTML += '#btinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #C42021; font-size: 1.5rem; top: 0.45rem; right: .6rem;}'
                        
                    }
            }
        }

        passInput.onkeyup = () => {
            checkRegex(passInput);
        };

        // Dès lors que l'utilisateur appuiera sur le bouton de validation la fonction ci-dessous viendras vérifier les couleurs de bordures
        // Si toutes les bordures sont vertes le formulaire sera envoyés 
        // Une refactorisation sera faites car en terme de securité c'est assez desastreux

        document.getElementById('submit-action').addEventListener('click', (e) => {
            if(errorAccname === 0 && errorAccmail === 0 && errorAccpass === 0) {
                
            } else {
                e.preventDefault();

                let error = document.getElementById('notif');
                let errArr = [passInput, mailInput, firstInput];
                for(let i=0; i < errArr.length; i++) {
                    if(errArr[i].style.border === "" && errArr[i].getAttribute('type') === "text") {
                            error.innerHTML = "<div class='errormsg'>Veuillez entrer un nom d'utilisateur</div>"
                    } else if(errArr[i].style.border === "" && errArr[i].getAttribute('type') === "email") {
                            error.innerHTML = "<div class='errormsg'>Veuillez entrer une adresse mail</div>"
                    } else if(errArr[i].style.border === "" && errArr[i].getAttribute('type') === "password") {
                            error.innerHTML = "<div class='errormsg'>Veuillez entrer un mot de passe</div>"
                    } else if(errArr[i].style.border === "1px solid rgb(196, 32, 33)"
                    && errArr[i].getAttribute('type') === "text") {
                    error.innerHTML = "<div class='errormsg'>Ce pseudonyme est déjà utilisé</div>"
                    }
                        else if(errArr[i].style.border === "1px solid rgb(226, 2, 3)"
                                && errArr[i].getAttribute('type') === "text") {
                            error.innerHTML = "<div class='errormsg'>Le pseudonyme doit comporter 14 caractères maximum et commencer par 5 lettres minimum</div>"
                    } else if(errArr[i].style.border === "1px solid rgb(196, 32, 33)"
                                && errArr[i].getAttribute('type') === "email") {
                            error.innerHTML = "<div class='errormsg'>Cette adresse mail est déjà utilisée</div>"
                    }    
                    else if(errArr[i].style.border === "1px solid rgb(226, 2, 3)"
                                && errArr[i].getAttribute('type') === "email") {
                            error.innerHTML = "<div class='errormsg'>Le format de l'adresse mail est incorrecte</div>"
                    } else if(errArr[i].style.border === "1px solid rgb(196, 32, 33)"
                                && errArr[i].getAttribute('type') === "password") {
                            error.innerHTML = "<div class='errormsg'>Le mot de passe doit comporter 8 caractères minimum (majuscule, minuscule, caractères spécial, nombre)</div>"
                    }
                }
                error.style.display = "flex";
                setTimeout(() => {
                    error.style.display = "none";
                }, 5000);
            }
            })