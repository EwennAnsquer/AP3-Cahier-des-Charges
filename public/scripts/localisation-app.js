async function fetchData(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        throw new Error(error);
    }
}

async function addAllCentreRelaisColisMarker(centreRelaisColis, villeData, paysData, map, urlprotocolHost) {
    try {
        for (const e of centreRelaisColis) {
            const centreData = await fetchData(urlprotocolHost + e);
            const data = await fetchData("https://geocode.maps.co/search?city=" + villeData.nom + "&country=" + paysData.nom + "&postalcode=" + villeData.codePostal + "&street=" + centreData.adresse);
            var markerCentreRelais = L.marker([data[0].lat, data[0].lon]).addTo(map);
            markerCentreRelais.bindPopup(data[0].display_name);
        }
    } catch (e) {
        alert(e.message);
    }
}

async function initializeMap() {
    try {
        const url = window.location.href;
        const urlProtocolHost = window.location.protocol + "//" + window.location.host;
        const idVille = url.charAt(url.length - 1);

        const villeData = await fetchData(urlProtocolHost + "/api/villes/" + idVille);
        const centresRelaisColis = villeData.lesCentresRelaisColis;
        const paysData = await fetchData(urlProtocolHost + villeData.lePays);

        const geocodeData = await fetchData("https://geocode.maps.co/search?city=" + villeData.nom + "&country=" + paysData.nom + "&postalcode=" + villeData.codePostal);

        const map = L.map('map').setView([geocodeData[0].lat, geocodeData[0].lon], 10);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        await addAllCentreRelaisColisMarker(centresRelaisColis, villeData, paysData, map, urlProtocolHost);

    } catch (error) {
        alert(error.message);
    }
}

initializeMap();
