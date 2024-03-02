let map = L.map('map').setView([29.25, 53.14], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

let myIcon = L.icon({
    iconUrl: './assets/img/marker-icon.svg',
    iconSize: [48, 105],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
});

let greenhouseMarkerLayer = L.layerGroup().addTo(map);
let companyMarkerLayer = L.layerGroup().addTo(map);

function showDefaultTabMarkers() {
    defineMarkersAndInfo(greenhouseMarkers, greenhouseMarkerLayer);
    defineMarkersAndInfo(companyMarkers, companyMarkerLayer);
    greenhouseMarkerLayer.addTo(map);
    companyMarkerLayer.remove();
}

const greenhouseTab = document.querySelector('#greenhouseTab');
const companyTab = document.querySelector('#companyTab');

greenhouseTab.addEventListener('click', function (event) {
    event.preventDefault();
    if (!this.classList.contains('active')) {
        let newClasses = ['bg-[#258641]', 'text-gray-50', 'border-gray-200', 'hover:text-white', 'hover:bg-[#206133]', 'active'];
        let oldClasses = ['text-gray-900', 'bg-gray-200', 'border-gray-200'];

        oldClasses.forEach(element => {
            companyTab.classList.add(element);
            greenhouseTab.classList.remove(element);
        });

        newClasses.forEach(element => {
            companyTab.classList.remove(element);
            greenhouseTab.classList.add(element);
        });

        greenhouseMarkerLayer.addTo(map);
        companyMarkerLayer.remove();
    }
})

companyTab.addEventListener('click', function (event) {
    event.preventDefault();
    if (!this.classList.contains('active')) {
        let newClasses = ['bg-[#258641]', 'text-gray-50', 'border-gray-200', 'hover:text-white', 'hover:bg-[#206133]', 'active'];
        let oldClasses = ['text-gray-900', 'bg-gray-200', 'border-gray-200'];

        oldClasses.forEach(element => {
            greenhouseTab.classList.add(element);
            companyTab.classList.remove(element);
        });

        newClasses.forEach(element => {
            greenhouseTab.classList.remove(element);
            companyTab.classList.add(element);
        });

        companyMarkerLayer.addTo(map);
        greenhouseMarkerLayer.remove();
    }
})

function defineMarkersAndInfo(markersObj, markerLayer) {
    markersObj.forEach(function (markerInfo) {
        let marker = L.marker(markerInfo.coordinates, {
            icon: myIcon
        }).addTo(markerLayer);

        let popupContent = `
            <div class="custom-popup" dir="rtl">
                <h3>${markerInfo.name}</h3>
                <p class="my-2">${markerInfo.area}</p>
                <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">${markerInfo.product}</p>
                <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">${markerInfo.space}</p>
            </div>
        `;
        marker.bindPopup(popupContent);

        marker.on('click', function () {
            updateMarkerDetails(markerInfo);
        })
    });
}


const markerInfoEl = document.querySelector('#markers-info');

function updateMarkerDetails(markerInfo) {
    markerInfoEl.innerHTML = `
        <div class="marker-details w-full flex flex-col justify-center items-center text-center px-3" dir="rtl">
            <img class="my-3" src="${markerInfo.image ? markerInfo.image : './assets/img/default-image.svg'}">
            <h4>${markerInfo.name}</h4>
            <p class="my-2">${markerInfo.area}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">${markerInfo.space}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">${markerInfo.product}</p>
            <hr class="w-full border border-white"/>
            <p class="my-1">اتوماسیون شرکت سیمرغ هوشمند انرژی</p>
            <p class="my-1">برند سیمهوش</p>
            <hr class="w-full border border-white"/>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">دمای بیرون: ${markerInfo.outsideTemp}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">رطوبت بیرون: ${markerInfo.outsideHumidity}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">شدت نور محیط: ${markerInfo.lightIntensity}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">سرعت باد: ${markerInfo.windSpeed}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">دمای داخل سالن: ${markerInfo.insideTemp}</p>
            <p class="my-2 ${markerInfo.company ? 'hidden' : ''}">رطوبت داخل سالن: ${markerInfo.insideHumidity}</p>
        </div>
    `;
}


//          Add Buttons for Markers
// let markerButtonsContainer = document.getElementById('marker-buttons');
// greenhouseMarkers.forEach(function (markerInfo, index) {
//     let liEl = document.createElement('li');
//     liEl.classList.add('nav-item', 'my-1', 'border-bottom');
//
//     let aEl = document.createElement('a');
//     aEl.innerText = markerInfo.name;
//     aEl.setAttribute('href', '#');
//     aEl.classList.add('nav-link', 'text-white', 'pe-4');
//     aEl.onclick = function (event) {
//         event.preventDefault();
//         goToMarker(markerInfo, 14);
//     };
//     liEl.appendChild(aEl);
//     markerButtonsContainer.appendChild(liEl);
// });

// function goToMarker(markerInfo, zoom) {
//     map.setView(markerInfo.coordinates, zoom, {animate: true});
//
//     let popupContent = `<div class="custom-popup" dir="rtl">
//                                     <h3>${markerInfo.name}</h3>
//                                     <p class="my-2">${markerInfo.area}</p>
//                                     <p class="my-2">${markerInfo.product}</p>
//                                     <p class="my-2">${markerInfo.space}</p>
//                                 </div>
// `;
//     L.popup()
//         .setLatLng(markerInfo.coordinates)
//         .setContent(popupContent)
//         .openOn(map);
// }


showDefaultTabMarkers();
