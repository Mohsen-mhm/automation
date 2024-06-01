let map = L.map('map').setView([29.45, 53.14], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

let myIcon = L.icon({
    iconUrl: './assets/img/marker-icon.svg',
    iconSize: [42, 105],
    iconAnchor: [22, 94],
    popupAnchor: [-3, -76],
});

let greenhouseMarkerLayer = L.layerGroup().addTo(map);
let companyMarkerLayer = L.layerGroup().addTo(map);

function renderMarkers(type, markers) {
    if (type === 'greenhouse') {
        // greenhouseMarkerLayer.clearLayers();
        // defineMarkersAndInfo(markers, greenhouseMarkerLayer);
        // greenhouseMarkerLayer.addTo(map);
        // map.removeLayer(companyMarkerLayer);
        greenhouseMarkerLayer.clearLayers();
        defineMarkersAndInfo(markers, greenhouseMarkerLayer);
        map.addLayer(greenhouseMarkerLayer);
        map.removeLayer(companyMarkerLayer);
    } else if (type === 'company') {
        companyMarkerLayer.clearLayers();
        // defineMarkersAndInfo(markers, companyMarkerLayer);
        // companyMarkerLayer.addTo(map);
        // map.removeLayer(greenhouseMarkerLayer);
        companyMarkerLayer.clearLayers();
        defineMarkersAndInfo(markers, companyMarkerLayer);
        map.addLayer(companyMarkerLayer);
        map.removeLayer(greenhouseMarkerLayer);
    }
}

function showDefaultTabMarkers() {
    defineMarkersAndInfo(greenhouseMarkers, greenhouseMarkerLayer);
    defineMarkersAndInfo(companyMarkers, companyMarkerLayer);
    map.addLayer(greenhouseMarkerLayer);
    map.removeLayer(companyMarkerLayer);
}

const greenhouseTab = document.querySelector('#greenhouseTab');
const companyTab = document.querySelector('#companyTab');
const greenhouseFiltersSection = document.querySelector('#greenhouseFiltersSection');
const companyFiltersSection = document.querySelector('#companyFiltersSection');

greenhouseTab.addEventListener('click', function (event) {
    event.preventDefault();
    if (!this.classList.contains('active')) {
        let newClasses = ['bg-[#6058C3]', 'text-gray-50', 'border-gray-200', 'hover:text-white', 'hover:bg-[#7367F0]', 'active'];
        let oldClasses = ['text-gray-900', 'bg-gray-200', 'border-gray-200'];

        oldClasses.forEach(element => {
            companyTab.classList.add(element);
            greenhouseTab.classList.remove(element);
        });

        newClasses.forEach(element => {
            companyTab.classList.remove(element);
            greenhouseTab.classList.add(element);
        });

        greenhouseFiltersSection.classList.add('flex');
        greenhouseFiltersSection.classList.remove('hidden');
        companyFiltersSection.classList.add('hidden')
        companyFiltersSection.classList.remove('flex');

        greenhouseMarkerLayer.addTo(map);
        companyMarkerLayer.remove();
    }
})

companyTab.addEventListener('click', function (event) {
    event.preventDefault();
    if (!this.classList.contains('active')) {
        let newClasses = ['bg-[#6058C3]', 'text-gray-50', 'border-gray-200', 'hover:text-white', 'hover:bg-[#7367F0]', 'active'];
        let oldClasses = ['text-gray-900', 'bg-gray-200', 'border-gray-200'];

        oldClasses.forEach(element => {
            greenhouseTab.classList.add(element);
            companyTab.classList.remove(element);
        });

        newClasses.forEach(element => {
            greenhouseTab.classList.remove(element);
            companyTab.classList.add(element);
        });

        companyFiltersSection.classList.add('flex');
        companyFiltersSection.classList.remove('hidden');
        greenhouseFiltersSection.classList.add('hidden')
        greenhouseFiltersSection.classList.remove('flex');

        companyMarkerLayer.addTo(map);
        greenhouseMarkerLayer.remove();
    }
})

function defineMarkersAndInfo(markersObj, markerLayer) {
    markersObj.forEach(function (markerInfo) {
        let marker = L.marker(markerInfo.coordinates, {
            icon: myIcon
        }).addTo(markerLayer);

        marker.on('click', function () {
            updateMarkerDetails(markerInfo);
            let sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.click();
            }
        })
    });
}

const markerInfoEl = document.querySelector('#markers-info');

function updateMarkerDetails(markerInfo) {
    if (markerInfoEl) {
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
}

showDefaultTabMarkers();


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


