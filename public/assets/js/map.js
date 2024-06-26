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
        greenhouseMarkerLayer.clearLayers();
        defineMarkersAndInfo(markers, greenhouseMarkerLayer);
        map.addLayer(greenhouseMarkerLayer);
        map.removeLayer(companyMarkerLayer);
    } else if (type === 'company') {
        companyMarkerLayer.clearLayers();
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
const greenhouseFiltersList = document.querySelector('#greenhouseFiltersList');
const companyFiltersList = document.querySelector('#companyFiltersList');
const greenhouseFilterButtons = document.querySelectorAll('#greenhouseFiltersSection button');
const companyFilterButtons = document.querySelectorAll('#companyFiltersSection button');

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

        greenhouseFiltersSection.classList.add('opacity-100');
        greenhouseFiltersList.classList.remove('translate-y-16');
        greenhouseFiltersSection.classList.remove('opacity-0');

        companyFiltersSection.classList.add('opacity-0');
        companyFiltersList.classList.add('translate-y-16');
        companyFiltersList.classList.remove('z-40');
        companyFiltersSection.classList.remove('opacity-100');
        companyFiltersList.classList.remove('z-40');
        companyFiltersList.classList.add('z-0');
        greenhouseFiltersList.classList.remove('z-0');
        greenhouseFiltersList.classList.add('z-40');

        companyFilterButtons.forEach((item) => {
            item.setAttribute('disabled', '')
        });
        greenhouseFilterButtons.forEach((item) => {
            item.removeAttribute('disabled')
        });

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

        companyFiltersSection.classList.add('opacity-100');
        companyFiltersList.classList.remove('translate-y-16');
        companyFiltersSection.classList.remove('opacity-0');

        greenhouseFiltersSection.classList.add('opacity-0');
        greenhouseFiltersList.classList.add('translate-y-16');
        greenhouseFiltersSection.classList.remove('opacity-100');
        greenhouseFiltersList.classList.remove('z-40');
        greenhouseFiltersList.classList.add('z-0');
        companyFiltersList.classList.remove('z-0');
        companyFiltersList.classList.add('z-40');

        greenhouseFilterButtons.forEach((item) => {
            item.setAttribute('disabled', '')
        });
        companyFilterButtons.forEach((item) => {
            item.removeAttribute('disabled')
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
        <div class="marker-details w-full flex flex-col justify-start items-start text-center px-3" dir="rtl">
            <img class="my-3" src="${markerInfo.image ? markerInfo.image : './assets/img/default-image.svg'}">
            <h4>${markerInfo.name}</h4>
            <p class="my-2 text-start flex">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                </svg>&nbsp;
                    ${markerInfo.area}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h4V4m12 4h-4V4M4 16h4v4m12-4h-4v4"/>
                </svg>&nbsp;
                    ${markerInfo.space}
            </p>

            <p class="my-2 mb-5 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-800 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
                </svg>&nbsp;
                    ${markerInfo.product}
            </p>
            <hr class="w-full border border-gray-300 mb-5"/>

            <p class="my-1 text-start">اتوماسیون شرکت سیمرغ هوشمند انرژی</p>
            <p class="my-1 text-start">برند سیمهوش</p>

            <hr class="w-full border border-gray-300 mt-5"/>

            <p class="mb-2 mt-5 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8.597 3.2A1 1 0 0 0 7.04 4.289a3.49 3.49 0 0 1 .057 1.795 3.448 3.448 0 0 1-.84 1.575.999.999 0 0 0-.077.094c-.596.817-3.96 5.6-.941 10.762l.03.049a7.73 7.73 0 0 0 2.917 2.602 7.617 7.617 0 0 0 3.772.829 8.06 8.06 0 0 0 3.986-.975 8.185 8.185 0 0 0 3.04-2.864c1.301-2.2 1.184-4.556.588-6.441-.583-1.848-1.68-3.414-2.607-4.102a1 1 0 0 0-1.594.757c-.067 1.431-.363 2.551-.794 3.431-.222-2.407-1.127-4.196-2.224-5.524-1.147-1.39-2.564-2.3-3.323-2.788a8.487 8.487 0 0 1-.432-.287Z"/>
                </svg>&nbsp;
                دمای بیرون: ${markerInfo.outsideTemp}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>&nbsp;
                رطوبت بیرون: ${markerInfo.outsideHumidity}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                </svg>&nbsp;
                شدت نور محیط: ${markerInfo.lightIntensity}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-5 h-5 text-gray-300" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                </svg>&nbsp;
                سرعت باد: ${markerInfo.windSpeed}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8.597 3.2A1 1 0 0 0 7.04 4.289a3.49 3.49 0 0 1 .057 1.795 3.448 3.448 0 0 1-.84 1.575.999.999 0 0 0-.077.094c-.596.817-3.96 5.6-.941 10.762l.03.049a7.73 7.73 0 0 0 2.917 2.602 7.617 7.617 0 0 0 3.772.829 8.06 8.06 0 0 0 3.986-.975 8.185 8.185 0 0 0 3.04-2.864c1.301-2.2 1.184-4.556.588-6.441-.583-1.848-1.68-3.414-2.607-4.102a1 1 0 0 0-1.594.757c-.067 1.431-.363 2.551-.794 3.431-.222-2.407-1.127-4.196-2.224-5.524-1.147-1.39-2.564-2.3-3.323-2.788a8.487 8.487 0 0 1-.432-.287Z"/>
                </svg>&nbsp;
                دمای داخل سالن: ${markerInfo.insideTemp}
            </p>

            <p class="my-2 text-start ${markerInfo.company ? 'hidden' : 'flex'}">
                <svg class="w-6 h-6 text-gray-300" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                          d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>&nbsp;
                رطوبت داخل سالن: ${markerInfo.insideHumidity}
            </p>
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


