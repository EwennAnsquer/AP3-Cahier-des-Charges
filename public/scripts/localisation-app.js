async function fetchData(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        throw new Error(error);
    }
}

async function addAllCentreRelaisColisMarker(centreRelaisColis, villeData, map){
    try{
        for (const e of centreRelaisColis) {
            const data = await fetchData("https://geocode.maps.co/search?city=" + villeData.nom + "&country=" + villeData.pays + "&postalcode=" + villeData.codePostal + "&street=" + e.adresse);
            var markerCentreRelais = L.marker([data[0].lat, data[0].lon]).addTo(map);
            markerCentreRelais.bindPopup(data[0].display_name);
        }
    } catch (e) {
        alert(e.message)
    }
}

async function initializeMap() {
    try {
        const url = window.location.href;
        const urlprotocolHost = window.location.protocol + "//" +window.location.host;
        const idVille = url.charAt(url.length - 1);

        const villeData = await fetchData(urlprotocolHost+"/api/villes/" + idVille);
        const centresRelaisColis = villeData.lesCentresRelaisColis;

        console.log(centresRelaisColis)

        const geocodeData = await fetchData("https://geocode.maps.co/search?city=" + villeData.nom + "&country=" + villeData.pays + "&postalcode=" + villeData.codePostal);

        const map = L.map('map').setView([geocodeData[0].lat, geocodeData[0].lon],10);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        await addAllCentreRelaisColisMarker(centresRelaisColis, villeData, map);

    } catch (error) {
        alert(error.message);
    }
}

initializeMap();
