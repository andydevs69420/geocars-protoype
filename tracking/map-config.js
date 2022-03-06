
const map = L.map("tracking-map");

const layerConfig0 = {
    minZoom: 14,
    maxZoom: 16,
    attribution: "© <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors"
};

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",layerConfig0).addTo(map);

var marker;

let isViewSet = false;

let isAdded   = false; 

let polyLine  = L.polyline([], {color: "#7847f5",weight:2});

export const onMapUpdate = (lat,lng,locationHist) => {

    let latlng = [lat,lng];

    if (!isViewSet) {
        isViewSet = true;
        map.setView(latlng,16);
        polyLine.addTo(map);
    }
    else {
        map.setView(latlng,16);
    }

    if (marker == undefined)
        marker = L.marker(latlng).addTo(map);
    else
        marker.setLatLng(latlng).update();
   
    if (!isAdded) {
        isAdded = true;
        locationHist.forEach((map_element) => {
            polyLine.addLatLng([map_element.lat,map_element.lng]);
        });
    }
   
    if (!polyLine._latlngs.includes(latlng))
        polyLine.addLatLng(latlng);
    
};
