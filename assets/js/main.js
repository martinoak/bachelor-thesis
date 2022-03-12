//Získání tlačítka:
mybutton = document.getElementById("backToTop");

document.addEventListener("DOMContentLoaded", loadAfterDom);

function loadAfterDom() {
    filterSelection("vse");
    const elements = document.querySelectorAll(".dropdown-item, .reference-button-small");
    for (let index = 0; index < elements.length; index++) {
        elements[index].addEventListener("click", navigationItemClick);
    }
    document
        .getElementById("selectType")
        .addEventListener("change", selectChange);

    const form = document.getElementById("form")
    form.addEventListener("submit", async (event) => {
        const mailSuccess = document.getElementById("mailSuccess")
        event.preventDefault();
        const formData = new FormData(form)
        const response = await fetch("actions/action.php", {
            method: "POST",
            body: formData
        })
        if (response.ok) {
            mailSuccess.classList.add("color-secondary");
            mailSuccess.innerText = "Email byl uspesne odeslan";
        } else {
            mailSuccess.classList.add("color-primary");
            mailSuccess.innerText = "Pri odesilani emailu nastala chyba";
        }
    });
}

function navigationItemClick(event) {
    let value = event.target.getAttribute("data-value");
    filterSelection(value);
    document.getElementById("selectType").value = value;
}

function selectChange(event) {
    let value = event.target.value;
    filterSelection(value);
}

// Pokud uživatel udělá scroll down větší než 20 pixelů, ukáže se back to top tlačítko
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 500 ||
        document.documentElement.scrollTop > 500
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// Pokud uživatel klikne na tlařítko, přesměruje jej to zpět nahoru
function topFunction() {
    document.body.scrollTop = 0; // Pro Safari
    document.documentElement.scrollTop = 0; // Pro Chrome, Firefox, IE a Opera prohlížeče
}

// ----------------------
// Filtr výběru reference
// ----------------------
function filterSelection(value) {
    var x, i;
    x = document.getElementsByClassName("filterClass");
    if (value === "vse") value = "";
    // Přidej třídu show (display:block) k vyfiltrovaným elementům a odstraň "show" od elementů které nebyly vybrány
    for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(value) > -1) w3AddClass(x[i], "show");
    }
}

// Ukaž vyfiltrované elementy
function w3AddClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        if (arr1.indexOf(arr2[i]) === -1) {
            element.className += " " + arr2[i];
        }
    }
}

// Schovej elementy které nebyly vybrány
function w3RemoveClass(element, name) {
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1);
        }
    }
    element.className = arr1.join(" ");
}
