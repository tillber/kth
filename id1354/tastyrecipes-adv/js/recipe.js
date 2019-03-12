function loadXMLDoc(route, k){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            readRecipes(this, k);
            alert(k);
        }
    }

    xmlhttp.open("GET", route, true);
    xmlhttp.send();
}

function getURLParameter(key){
    key = key.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(logation.search);

    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function readRecipes(xml, j){
    var xmlDoc = xml.responseXML;
    var recipes = xmlDoc.getElementsByTagName("recipe");
    for(var i = j; i < (recipes.length + j); i++){
        var card = document.getElementById("cardImage" + i);
        card.setAttribute("src", recipes[i].getElementsByTagName("image")[0].childNodes[0].nodeValue);

        card = document.getElementById("cardTitle" + i);
        card.setAttribute("href", "recipe.html?country=" + getUrlParameter("country") + "&title=" + recipes[i].getAttribute("title"));
        card.innerHTML = recipes[i].getAttribute("title");

        card = document.getElementById("cardTime" + i);
        card.innerHTML = "TILLAGNINGSTID " + recipes[i].getElementsByTagName("time")[0].childNodes[0].nodeValue + " MIN";

        card = document.getElementById("cardDesc" + i);
        card.innerHTML = recipes[i].getElementsByTagName("description")[0].childNodes[0].nodeValue;

        j++;
    }
}


//loadXMLDoc("data/indien.xml", j);
