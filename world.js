document.addEventListener("DOMContentLoaded", function () {
    const lookupButton = document.getElementById("lookup");
    const countryInput = document.getElementById("country");
    const result = document.getElementById("result");

    lookupButton.addEventListener("click", function () {
        const country = countryInput.value.trim();
        if (country === "") {
            result.textContent = "Please enter a country name.";
            return;
        }

        const citiesButton = document.getElementById("lookup-cities");

        citiesButton.addEventListener("click", function () {
            const country = countryInput.value.trim();

            if (country === "") {
                result.textContent = "Please enter a country name.";
                return;
            }

            fetch("world.php?country=" +
                encodeURIComponent(country) + "&lookup=cities")
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error("Request failed");
                    }
                    return response.text();
                })
                .then(function (data) {
                    result.innerHTML = data;
                })
                .catch(function (error) {
                    console.error(error);
                    result.textContent = "Unable to retrieve cities.";
                });
        });

        fetch("world.php?country=" + encodeURIComponent(country))
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("Request failed");
                }
                return response.text();
            })
            .then(function (data) {
                result.innerHTML = data;
            })
            .catch(function (error) {
                console.error(error);
                result.textContent = "Unable to retrieve countries.";
            });
    });
});