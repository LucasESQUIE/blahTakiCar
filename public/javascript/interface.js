function Switch(dep,arr) {
    document.getElementById("villeDep").value = arr;
    document.getElementById("villeArr").value = dep;
}


// page profil
function Fichier() {
    document.getElementById('my_file').click();
}

function affichDefault() {
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
}

function openPage(pageName, elmnt) {
    // Hide all elements with class="tabcontent" by default */
    var i, tabcontent;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Show the specific tab content
    document.getElementById(pageName).style.display = "block";
}







