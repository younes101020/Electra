// Permet de déterminer quel page html execute le script afin de partitionner chaque bout de code
// avec la page html qui lui correspond ce qui me permettra de ne pas recréer un fichier javascript
// pour chaque page html
let filename = location.pathname.split('/').pop();

let styleElem = document.head.appendChild(document.createElement("style"));


if(filename == "loginController.php" || filename == "registerController.php") {
    // Création d'une balise style qui sera utiliser dynamiquement

        

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

        let error = document.getElementById('notif');


        let mobileNavbar = document.querySelector('.toggle_menu');
        let togglemenu = document.querySelectorAll("a")[5].classList;

        let mobileTl = gsap.timeline({});

        gsap.set(".navcontainer", {autoAlpha:0,x: 900});

        mobileNavbar.addEventListener('click', function() {
            console.log('test')
            if(!togglemenu.toggle("toggle_func")) {
                mobileTl.to(".navcontainer", {autoAlpha: 1,x: 0});
                mobileTl.to(".toggle_bar", {backgroundColor: "black"})
                mobileTl.to(".top", {transform: "rotate(36deg)", position: "absolute"}, "-=1");
                mobileTl.to(".middle", {autoAlpha:0}, "-=1");
                mobileTl.to(".bottom", {transform: "rotate(-36deg)", position: "absolute"}, "-=1");
                mobileTl.restart();
            } else {
                mobileTl.reverse();
            }
        });
        gsap.set(".litem", {x:900});
        gsap.set(".logo", {autoAlpha: 0});

        let tl = gsap.timeline({duration:1});
        
        let editbtn = document.querySelector('.fa-pen')

        tl.to(".spidermanbox", {x: -900});
        tl.to(".womenbox", {x: -900});
        tl.to(".communitybox", {x: -900});
        
        tl.to(".logo", {autoAlpha: 1});

        let editTl = gsap.timeline({});

        let toggleEdit = document.querySelector('.changelistname').classList;
        gsap.set(".changelistname", {autoAlpha: 0, y:-900});

        editbtn.addEventListener('click', function() {
            if(!toggleEdit.toggle('toggleedit')) {
                editTl.to(".changelistname", {y:0, autoAlpha: 1});
                editTl.restart();
            } else {
                editTl.reverse();
            }
            
        })

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
} else if(filename == "showController.php") {

    // Cette fonction vérifie l'état visuel des like sur les movielist
    const checkshowinListsync = (checkedshow, indiceiszero, indice) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(indiceiszero) {
                if(this.responseText == "Le film est déjà dans la movielist !") {
                    localStorage.setItem("--dynamic-color", "red");
                    document.documentElement.style.setProperty("--dynamic-color", localStorage.getItem("--dynamic-color"));
                } else {
                    localStorage.setItem("--dynamic-color", "black");
                    document.documentElement.style.setProperty("--dynamic-color", localStorage.getItem("--dynamic-color"));
                }
            } else {
                if(this.responseText == "Le film est déjà dans la movielist !") {
                    localStorage.setItem(`--${indice}${indice}`, "red");
                    document.documentElement.style.setProperty(`--${indice}${indice}`, localStorage.getItem(`--${indice}${indice}`));
                } else {
                    localStorage.setItem(`--${indice}${indice}`, "black")
                    document.documentElement.style.setProperty(`--${indice}${indice}`, localStorage.getItem(`--${indice}${indice}`));
                }
            }
                
            }
        }

        xmlhttp.open("GET", "../controllers/indexController.php?checkedshow=" + checkedshow, true)
        xmlhttp.send();
    };
    
    let like_scope = document.querySelectorAll('.like_scope');
    let indiceiszeroSync;

    //Initialiation de la couleur des coeurs
    window.addEventListener('load', () => {
            for(let i  = 0; i < 12; i++) {
            if(i == 0) {
                indiceiszeroSync = true;
                checkshowinListsync(like_scope[i].childNodes[1].childNodes[1].textContent,indiceiszeroSync,i);
            } else {
                indiceiszeroSync = false;
                checkshowinListsync(like_scope[i].childNodes[1].childNodes[1].textContent,indiceiszeroSync,i);
            }
        }
    });
    

    const searchValue = document.getElementById('search_bar');
    const showContainer = document.getElementById('show');

    const checkexistShow = () => {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                    // Je parse les données recu pour les transformer de chaines de charactères
                    // en objets ce qui me permettra d'itérer decu
                    console.log(this.responseText);
                    let showResult = JSON.parse(this.responseText);
                    console.log(showResult.name.trim());
                    showContainer.innerHTML = `<div id="top_show" class="like_scope result_search" style="background-image: url(${showResult.image.trim()}); background-size: cover; background-position: center;">
                                                    <div class="top_showcard-content">
                                                        <p class="showcard-title">${showResult.name.trim()}</p>
                                                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                                                        <button class="top_resume_btn resume_btn">résumé | <i class="fa-solid fa-plus"></i></button>
                                                        <p class="synopsis">${showResult.synopsis.trim()}</p>
                                                        <a target="_BLANK" href="${showResult.buy.trim()}" class="buy_btn">Achetez <i class="fa-solid fa-cart-shopping"></i></a>
                                                    </div>
                                                </div>`
                    
                    allowAsync()
                }
        }
            xmlhttp.open("GET", "../controllers/indexController.php?search=" + searchValue.value, true)
            xmlhttp.send();
        };

        searchValue.onkeyup = () => {
            checkexistShow();
        }

    const allowAsync = () => {

        let resumeBtn = document.querySelectorAll('.resume_btn');

        let nodes = document.getElementById('show').childNodes;
        // Cibler les pseudo element coeur afin de pouvoir changer leurs couleurs au clique
        let element = document.getElementById('top_show');
        let styles = window.getComputedStyle(element,':after').getPropertyValue('content');
        let toggleChecker = [true, true, true, true, true, true, true, true, true, true, true, true];
        let stars = document.querySelectorAll('.stars');
        let plus = document.querySelectorAll('.fa-plus');
        let titleCard = document.querySelectorAll('.showcard-title');
        let buyBtn = document.querySelectorAll('.buy_btn');
        let synopsis = document.querySelectorAll('.synopsis');

        for(let i = 0; i < resumeBtn.length; i++) {
            resumeBtn[i].addEventListener('click', () => {
                    if(i == 0 && toggleChecker[i] == true) {
                        if(window.matchMedia("(max-width: 1230px)").matches) {
                            gsap.to(synopsis[i], 1, {position: "static",display: "block",color:"#F1D302",fontSize:"1.5rem"});
                            gsap.to(buyBtn[i], 1, {display: "block",bottom:"auto",left:"12rem",fontSize:"2rem",padding: "0.3rem 0.8rem"});
                        } else {
                            gsap.to(synopsis[i], 1, {position: "absolute",top:"7rem",display: "block",color:"#F1D302",fontSize:"1.5rem"});
                            gsap.to(buyBtn[i], 1, {display: "block"});
                        }
                        document.documentElement.style.setProperty("--dynamic-visibility", "hidden");
                        gsap.to("#top_show", 1, {paddingTop:"0"});
                        gsap.to(plus[i], 1, {rotation:45});
                        gsap.to(stars[i], 0, {display:"none"});
                        gsap.to(titleCard[i], 0, {display:"none"});
                        top_badge = "none";
                        toggleChecker[i] = false;
                } else if(i == 0) {
                    if(window.matchMedia("(max-width: 1230px)").matches) {
                        gsap.to("#top_show", 1, {paddingTop:"8.5rem"});
                    } else {
                        gsap.to("#top_show", 1, {paddingTop:"20rem"});
                    }
                    gsap.to(plus[i], 1, {rotation:0});
                    gsap.fromTo(stars[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.fromTo(titleCard[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.to(synopsis[i], 0, {display:"none"});
                    toggleChecker[i] = true;
                    document.documentElement.style.setProperty("--dynamic-visibility", "unset");
                    gsap.to(buyBtn[i], 0, {display: "none"});
                } else if(toggleChecker[i] == true) {
                        toggleChecker[i] = false;
                        document.documentElement.style.setProperty(`--${i}`, "hidden");
                        gsap.to(`#show_${[i]}`, 1, {paddingTop:"0"});
                        gsap.to(plus[i], 1, {rotation:45});
                        gsap.to(stars[i], 0, {display:"none"});
                        gsap.to(titleCard[i], 0, {display:"none"});
                        gsap.to(synopsis[i], 0, {display:"block"});
                        gsap.to(buyBtn[i], 0, {display:"block"});
                        if (i == 11 && window.matchMedia("(max-width: 1230px)").matches) {
                            gsap.to(`#show_${[i]}`, 1, {height:"15rem"});
                        }
                } else {
                        toggleChecker[i] = true;
                        document.documentElement.style.setProperty(`--${i}`, "unset");
                        gsap.to(`#show_${[i]}`, 1, {paddingTop:"8rem"});
                        gsap.to(plus[i], 1, {rotation:0});
                        gsap.fromTo(stars[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                        gsap.fromTo(titleCard[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                        gsap.to(synopsis[i], 0, {display:"none"});
                        gsap.to(buyBtn[i], 0, {display:"none"});
                        if (i == 11 && window.matchMedia("(max-width: 1230px)").matches) {
                            gsap.to(`#show_${[i]}`, 1, {height:"auto"});
                        }
                        
                }
            });
        }

        // Cette fonction me sert à envoyer le nom du film à ajouter à la watchlist
         const saveShow = (savingshowTitle) => {
                    let xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                            console.log(this.responseText)
                    }
                    }
                    xmlhttp.open("GET", "../controllers/indexController.php?addingshow=" + savingshowTitle, true)
                    xmlhttp.send();
                };
        // Cette fonction me sert à supprimer un film spécifique de la movielist de l'utilisateur
        const deleteShow = (deletingshowTitle) => {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText)
            }
            }
            xmlhttp.open("GET", "../controllers/indexController.php?deletingshow=" + deletingshowTitle, true)
            xmlhttp.send();
        };
        // Cette fonction vérifie l'état visuel des like sur les movielist
        const checkshowinList = (checkedshow, saveshow, deleteshow, indiceiszero, indice) => {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if(indiceiszero) {
                    if(this.responseText == "Le film est déjà dans la movielist !") {
                        deleteshow(checkedshow);
                        localStorage.setItem("--dynamic-color", "black")
                        document.documentElement.style.setProperty("--dynamic-color", localStorage.getItem("--dynamic-color"));
                    } else {
                        saveshow(checkedshow);
                        localStorage.setItem("--dynamic-color", "red")
                        document.documentElement.style.setProperty("--dynamic-color", localStorage.getItem("--dynamic-color"));
                    }
                } else {
                    if(this.responseText == "Le film est déjà dans la movielist !") {
                        deleteshow(checkedshow);
                        localStorage.setItem(`--${indice}${indice}`, "black")
                        document.documentElement.style.setProperty(`--${indice}${indice}`, localStorage.getItem(`--${indice}${indice}`));
                    } else {
                        saveshow(checkedshow);
                        localStorage.setItem(`--${indice}${indice}`, "red");
                        document.documentElement.style.setProperty(`--${indice}${indice}`, localStorage.getItem(`--${indice}${indice}`));
                    }
                }
                    
            }
            }
            xmlhttp.open("GET", "../controllers/indexController.php?checkedshow=" + checkedshow, true)
            xmlhttp.send();
        }
        // firstInput.onkeyup = () => {
        //     checkexistName();
        // }

        let indiceisZero;

        for(let i = 0; i < resumeBtn.length; i++) {
            like_scope[i].addEventListener("click", (e) => {
                    e.stopPropagation();
                    if(i == 0) {
                        indiceisZero = true;
                        checkshowinList(like_scope[i].childNodes[1].childNodes[1].textContent,saveShow,deleteShow,indiceisZero,i);
                    } else {
                        indiceisZero = false;
                        checkshowinList(like_scope[i].childNodes[1].childNodes[1].textContent,saveShow,deleteShow,indiceisZero,i);
                    }
            })
            
            
        };

        window.addEventListener('resize', () => {
            for(let i = 0; i < resumeBtn.length; i++) {
                    if(window.matchMedia("(max-width: 1230px)").matches && toggleChecker[0] == false && i == 0) {
                    gsap.to("#top_show", 1, {paddingTop:"8.5rem"});
                    gsap.to(buyBtn[i], 1, {display: "block",bottom:"auto",left:"12rem",fontSize:"2rem",padding: "0.3rem 0.8rem"});
                    toggleChecker[0] = true;
                } else if(toggleChecker[0] == false && i == 0) {
                    gsap.to("#top_show", 1, {paddingTop:"20rem"});
                    gsap.to(buyBtn[i], 1, {display: "block",bottom:"6rem",left:"4.5rem",fontSize:"1.5rem",padding: "0.5rem 1rem"});
                    toggleChecker[0] = true;
                } else if(window.matchMedia("(max-width: 1230px)").matches && i == 0) {
                    gsap.to(buyBtn[i], 1, {display: "none"});
                    gsap.to("#top_show", 1, {paddingTop:"8.5rem"});
                    gsap.to(plus[i], 1, {rotation:0});
                    gsap.fromTo(stars[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.fromTo(titleCard[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.to(synopsis[i], 0, {display:"none"});
                } else if(i == 0) {
                    gsap.to(buyBtn[i], 1, {display: "none"});
                    gsap.to("#top_show", 1, {paddingTop:"20rem"});
                    gsap.to(plus[i], 1, {rotation:0});
                    gsap.fromTo(stars[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.fromTo(titleCard[i], {display: "block", opacity: 0}, {opacity: 1, duration: 1});
                    gsap.to(synopsis[i], 0, {display:"none"});
                }
            }
            
        });
    }
    
    allowAsync();

    
} else if(filename == "showlistController.php") {

    let checkbox = document.getElementById('check');

    const getCurrentStatus = () => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 1) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
        }
        }
        xmlhttp.open("GET", "../controllers/indexController.php?getstatuslist=pasbesoindeparam", false);
        xmlhttp.send();
    };

    document.addEventListener('DOMContentLoaded', getCurrentStatus());

    let errorAcclistname;

    let submit = document.getElementById('confirmlistname');
    

    let listname = document.getElementById('listname');

    const checkexistListName = () => {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                    if(this.responseText != "false") {
                        errorAcclistname = 2;
                        listname.style.border = "solid 1px #C42021";
                        styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #E20203; font-size: 1rem; top: 0.36rem; right: .6rem;}'
                    } else if(!/^.{4,18}$/gi.test(listname.value)) {
                        errorAcclistname = 1;
                        listname.style.border = "solid 1px #C42021";
                        styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f06a"; color: #C42021; font-size: 1rem; top: 0.36rem; right: .6rem;}'
                    } else {
                        errorAcclistname = 0;
                        listname.style.border = "solid 1px #5AFF15";
                        styleElem.innerHTML += '#bsinput::before {position: absolute; font-family: FontAwesome; content: "\\f058"; color: #5AFF15; font-size: 1rem; top: 0.36rem; right: .6rem;}'
                    }
                }
                }
            xmlhttp.open("GET", "../controllers/indexController.php?listname=" + listname.value, true)
            xmlhttp.send();
        };

    listname.onkeyup = () => {
        checkexistListName();
    }

    const animationError = () => {
        gsap.to("#notif", {y: 50, duration: 3, delay: 1});
        gsap.to("#notif", {opacity: 0, duration: 1, delay: 2});
    }

    

    submit.addEventListener('click', (e) => {
        if(errorAcclistname === 0) {

        } else if(errorAcclistname === 1) {
            e.preventDefault();
            error.innerHTML = "<div class='errormsg'>Un nom de liste doit comporter 4 caractères minimum.</div>"
            animationError();
        } else if(errorAcclistname === 2) {
            e.preventDefault();
            error.innerHTML = "<div class='errormsg'>Ce nom de liste est déjà utiliser.</div>"
            animationError();
        } else {
            e.preventDefault();
            error.innerHTML = "<div class='errormsg'>Veuillez entrer un nom de liste.</div>"
            animationError();
        }
    });

    const changeStatus = (statusValue) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
        }
        }
        xmlhttp.open("GET", "../controllers/indexController.php?statuslist=" + statusValue, true);
        xmlhttp.send();
    };

    checkbox.addEventListener('click', function() {
        if(checkbox.checked == true) {
            changeStatus(1);
        } else {
            changeStatus(0);
        }
    })

    let removed = document.querySelectorAll('.removed');
    let title = document.querySelectorAll('.card-title');

    const deleteShow = (deletingshowTitle) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText)
        }
        }
        xmlhttp.open("GET", "../controllers/indexController.php?deletingshow=" + deletingshowTitle, true)
        xmlhttp.send();
    };

    for(let i = 0; i < removed.length; i++) {
        removed[i].addEventListener("click", (e) => {
                e.stopPropagation();
                deleteShow(title[i].childNodes[0].childNodes[0].textContent);
                location.reload();
        })
    }

} else if(filename == "timelineController.php") {
    let commentTl = gsap.timeline({});

    let commentBtn = document.querySelector('.comments');
    let toggle = document.querySelector('.tl_card_body').classList;

    let submit = document.querySelector('.submit_btn');
    let commentaire = document.getElementById('commentaire');

    commentBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if(!toggle.toggle('togglecomment')) {
            commentTl.to('.buy', {autoAlpha: 0});
            commentTl.to('.tl_card_body', {height: "100%"});
            commentTl.to('.comments', {y: -190}, "<");
            commentTl.to('.movielistname', {x: -150}, "<")
            commentTl.to('.tl_card_title', {x: -150}, "<");
            commentTl.to('.form-comment', {display: "flex"})
            commentTl.restart();
        } else {
            commentTl.reverse();
        }
        
    });

    submit.addEventListener('click', function(e) {
        if(/[A-Z0-9]{1,}/.test(commentaire.value)) {
            error.innerHTML = "<div class='successmsg'>Votre message a bien été envoyé.</div>"
        } else {
            e.preventDefault();
            error.innerHTML = "<div class='errormsg'>Votre message n'as pas été envoyé.</div>"
        } 
    })

}

    

    