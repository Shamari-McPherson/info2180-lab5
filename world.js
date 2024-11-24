window.onload = function () {
    var countryInput;
    
    document.getElementById("searchButton").addEventListener("click", function (event) {
        event.preventDefault();

        countryInput = document.getElementById("country").value.trim().replace(/(<([^>]+)>)/gi, "");

        const httpRequest = new XMLHttpRequest();
        httpRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result").innerHTML = this.responseText;
            }
        };
        httpRequest.open("GET", "world.php?country=" + countryInput);
        httpRequest.send();
    });

    document.getElementById("searchCitiesButton").addEventListener("click", function (event) {
        event.preventDefault();

        countryInput = document.getElementById("country").value.trim().replace(/(<([^>]+)>)/gi, "");

        if (countryInput !== "") {
            const cityRequest = new XMLHttpRequest();
            cityRequest.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result").innerHTML = this.responseText;
                }
            };
            cityRequest.open("GET", "world.php?country=" + countryInput + "&lookup=cities");
            cityRequest.send();
        }
    });
};