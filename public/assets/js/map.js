// Initialize map with modern styling
let map = L.map('map', {
    zoomControl: false,
    attributionControl: false
}).setView([29.45, 53.14], 7);

// Add custom zoom control in top-right
L.control.zoom({
    position: 'topright'
}).addTo(map);

// Modern tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 18,
    className: 'map-tiles'
}).addTo(map);

// Custom modern marker icons
const createCustomIcon = (type) => {
    const iconConfig = {
        greenhouse: {
            html: `
                <div class="custom-marker greenhouse-marker">
                    <div class="marker-inner">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="marker-pulse"></div>
                </div>
            `,
            className: 'greenhouse-marker-container',
            iconSize: [40, 40],
            iconAnchor: [20, 35],
            popupAnchor: [0, -35]
        },
        company: {
            html: `
                <div class="custom-marker company-marker">
                    <div class="marker-inner">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="marker-pulse"></div>
                </div>
            `,
            className: 'company-marker-container',
            iconSize: [40, 40],
            iconAnchor: [20, 35],
            popupAnchor: [0, -35]
        }
    };

    return L.divIcon(iconConfig[type]);
};

// Layer groups for different marker types
let greenhouseMarkerLayer = L.layerGroup().addTo(map);
let companyMarkerLayer = L.layerGroup();

// Current active tab state
let currentTab = 'greenhouse';

// Enhanced marker rendering without clustering
function renderMarkers(type, markers) {
    currentTab = type;

    if (type === 'greenhouse') {
        greenhouseMarkerLayer.clearLayers();
        defineMarkersAndInfo(markers, greenhouseMarkerLayer, 'greenhouse');

        if (!map.hasLayer(greenhouseMarkerLayer)) {
            map.addLayer(greenhouseMarkerLayer);
        }
        if (map.hasLayer(companyMarkerLayer)) {
            map.removeLayer(companyMarkerLayer);
        }
    } else if (type === 'company') {
        companyMarkerLayer.clearLayers();
        defineMarkersAndInfo(markers, companyMarkerLayer, 'company');

        if (!map.hasLayer(companyMarkerLayer)) {
            map.addLayer(companyMarkerLayer);
        }
        if (map.hasLayer(greenhouseMarkerLayer)) {
            map.removeLayer(greenhouseMarkerLayer);
        }
    }

    // Update tab visual state
    updateTabState(type);
}

// Initialize default markers
function showDefaultTabMarkers() {
    if (typeof greenhouseMarkers !== 'undefined' && greenhouseMarkers) {
        defineMarkersAndInfo(greenhouseMarkers, greenhouseMarkerLayer, 'greenhouse');
    }

    if (typeof companyMarkers !== 'undefined' && companyMarkers && companyMarkers.length > 0) {
        defineMarkersAndInfo(companyMarkers, companyMarkerLayer, 'company');
    }

    map.addLayer(greenhouseMarkerLayer);
    updateTabState('greenhouse');
}

// Enhanced tab state management
function updateTabState(activeType) {
    const greenhouseTab = document.querySelector('#greenhouseTab');
    const companyTab = document.querySelector('#companyTab');
    const greenhouseFilters = document.querySelector('#greenhouseFiltersList');
    const companyFilters = document.querySelector('#companyFiltersList');

    if (!greenhouseTab || !companyTab) return;

    // Reset both tabs
    [greenhouseTab, companyTab].forEach(tab => {
        tab.className = "flex-1 py-3 px-6 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 text-slate-600 hover:text-slate-800 hover:bg-slate-50";
    });

    // Activate selected tab
    const activeTab = activeType === 'greenhouse' ? greenhouseTab : companyTab;
    activeTab.className = "flex-1 py-3 px-6 text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-md";

    // Show/hide filters with smooth animation
    if (greenhouseFilters && companyFilters) {
        if (activeType === 'greenhouse') {
            greenhouseFilters.classList.remove('hidden');
            companyFilters.classList.add('hidden');
        } else {
            companyFilters.classList.remove('hidden');
            greenhouseFilters.classList.add('hidden');
        }
    }
}

// Enhanced popup creation with modern styling
function createModernPopup(markerInfo, type) {
    const isCompany = type === 'company' || markerInfo.company;

    return `
        <div class="modern-popup" dir="rtl">
            <div class="popup-header">
                <div class="popup-icon ${isCompany ? 'company' : 'greenhouse'}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="popup-title">
                    <h3>${markerInfo.name}</h3>
                    <span class="popup-type">${isCompany ? 'شرکت اتوماسیون' : 'گلخانه'}</span>
                </div>
            </div>

            <div class="popup-content">
                <div class="popup-info">
                    <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                    </svg>
                    <span>${markerInfo.area}</span>
                </div>

                ${!isCompany && markerInfo.product ? `
                    <div class="popup-info">
                        <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
                        </svg>
                        <span>${markerInfo.product}</span>
                    </div>
                ` : ''}

                ${!isCompany && markerInfo.space ? `
                    <div class="popup-info">
                        <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h4V4m12 4h-4V4M4 16h4v4m12-4h-4v4"/>
                        </svg>
                        <span>${markerInfo.space}</span>
                    </div>
                ` : ''}
            </div>

            <div class="popup-actions">
                <button type="button" onclick="openMarkerDetails('${markerInfo.name}')"
                        class="popup-button">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    جزئیات بیشتر
                </button>
            </div>
        </div>
    `;
}

// Enhanced marker definition without clustering
function defineMarkersAndInfo(markersObj, markerLayer, type) {
    if (!markersObj || !Array.isArray(markersObj)) return;

    markersObj.forEach(function (markerInfo, index) {
        const customIcon = createCustomIcon(type);

        const marker = L.marker(markerInfo.coordinates, {
            icon: customIcon,
            title: markerInfo.name
        });

        const popupContent = createModernPopup(markerInfo, type);

        marker.bindPopup(popupContent, {
            className: 'modern-popup-container',
            maxWidth: 320,
            closeButton: true,
            autoClose: true,
            autoPan: true
        });

        // Store marker info for details panel
        marker.markerInfo = markerInfo;
        marker.markerType = type;

        marker.on('click', function () {
            updateMarkerDetails(markerInfo, type);
        });

        // Add hover effects
        marker.on('mouseover', function (e) {
            const element = e.target.getElement();
            if (element) {
                element.classList.add('marker-hover');
            }
        });

        marker.on('mouseout', function (e) {
            const element = e.target.getElement();
            if (element) {
                element.classList.remove('marker-hover');
            }
        });

        markerLayer.addLayer(marker);
    });
}

// Enhanced marker details with modern styling
function updateMarkerDetails(markerInfo, type) {
    const markerInfoEl = document.querySelector('#markers-info');
    if (!markerInfoEl) return;

    const isCompany = type === 'company' || markerInfo.company;

    markerInfoEl.innerHTML = `
        <div class="marker-details-modern" dir="rtl">
            <div class="details-header">
                <div class="details-image">
                    <img src="${markerInfo.image || './assets/img/default-image.jpg'}"
                         alt="${markerInfo.name}"
                         onerror="this.src='./assets/img/default-image.jpg'">
                    <div class="image-overlay">
                        <div class="marker-type-badge ${isCompany ? 'company' : 'greenhouse'}">
                            ${isCompany ? 'شرکت' : 'گلخانه'}
                        </div>
                    </div>
                </div>
                <div class="details-title">
                    <h4>${markerInfo.name}</h4>
                </div>
            </div>

            <div class="details-content">
                <div class="info-section">
                    <h5>اطلاعات کلی</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="info-label">موقعیت:</span>
                            <span class="info-value">${markerInfo.area}</span>
                        </div>

                        ${!isCompany && markerInfo.space ? `
                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h4V4m12 4h-4V4M4 16h4v4m12-4h-4v4"/>
                                </svg>
                                <span class="info-label">مساحت:</span>
                                <span class="info-value">${markerInfo.space}</span>
                            </div>
                        ` : ''}

                        ${!isCompany && markerInfo.product ? `
                            <div class="info-item">
                                <svg class="info-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.16V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="info-label">محصول:</span>
                                <span class="info-value">${markerInfo.product}</span>
                            </div>
                        ` : ''}
                    </div>
                </div>

                <div class="divider"></div>

                <div class="info-section">
                    <h5>سیستم اتوماسیون</h5>
                    <div class="automation-info">
                        <p>شرکت سیمرغ هوشمند انرژی</p>
                        <p>برند سیمهوش</p>
                    </div>
                </div>

                ${!isCompany ? `
                    <div class="divider"></div>

                    <div class="info-section">
                        <h5>شرایط محیطی</h5>
                        <div class="environmental-grid">
                            <div class="env-card">
                                <div class="env-header">
                                    <svg class="env-icon" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.597 3.2A1 1 0 0 0 7.04 4.289a3.49 3.49 0 0 1 .057 1.795 3.448 3.448 0 0 1-.84 1.575.999.999 0 0 0-.077.094c-.596.817-3.96 5.6-.941 10.762l.03.049a7.73 7.73 0 0 0 2.917 2.602 7.617 7.617 0 0 0 3.772.829 8.06 8.06 0 0 0 3.986-.975 8.185 8.185 0 0 0 3.04-2.864c1.301-2.2 1.184-4.556.588-6.441-.583-1.848-1.68-3.414-2.607-4.102a1 1 0 0 0-1.594.757c-.067 1.431-.363 2.551-.794 3.431-.222-2.407-1.127-4.196-2.224-5.524-1.147-1.39-2.564-2.3-3.323-2.788a8.487 8.487 0 0 1-.432-.287Z"/>
                                    </svg>
                                    <span>دما</span>
                                </div>
                                <div class="env-values">
                                    <div class="env-item">
                                        <span class="env-label">بیرون:</span>
                                        <span class="env-value">${markerInfo.outsideTemp || 'N/A'}</span>
                                    </div>
                                    <div class="env-item">
                                        <span class="env-label">داخل:</span>
                                        <span class="env-value">${markerInfo.insideTemp || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="env-card">
                                <div class="env-header">
                                    <svg class="env-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-width="2" d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <span>رطوبت</span>
                                </div>
                                <div class="env-values">
                                    <div class="env-item">
                                        <span class="env-label">بیرون:</span>
                                        <span class="env-value">${markerInfo.outsideHumidity || 'N/A'}</span>
                                    </div>
                                    <div class="env-item">
                                        <span class="env-label">داخل:</span>
                                        <span class="env-value">${markerInfo.insideHumidity || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="env-card">
                                <div class="env-header">
                                    <svg class="env-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5V3m0 18v-2M7 7 5.7 5.7m12.8 12.8L17 17M5 12H3m18 0h-2M7 17l-1.4 1.4M18.4 5.6 17 7.1M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
                                    </svg>
                                    <span>نور</span>
                                </div>
                                <div class="env-values">
                                    <div class="env-item">
                                        <span class="env-label">شدت:</span>
                                        <span class="env-value">${markerInfo.lightIntensity || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="env-card">
                                <div class="env-header">
                                    <svg class="env-icon" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M11.8 5.7A4.8 4.8 0 0 0 7 10a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4 1c2-.7 2.9-3 3.1-4-1 1.4-2.4 2.2-4.3 1.2-1.2-.6-2.1-3.4-6-3.3Zm-5 6.3A4.8 4.8 0 0 0 2 16.2a3.4 3.4 0 0 1 2.7-1.7c1.7 0 3 2 3.8 2.6a5.7 5.7 0 0 0 5.4.9c2-.7 3-2.9 3.1-4-1 1.4-2.4 2.3-4.2 1.3-1.3-.7-2.2-3.4-6-3.3Z"/>
                                    </svg>
                                    <span>باد</span>
                                </div>
                                <div class="env-values">
                                    <div class="env-item">
                                        <span class="env-label">سرعت:</span>
                                        <span class="env-value">${markerInfo.windSpeed || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
}

// Global function for opening marker details (called from popup buttons)
window.openMarkerDetails = function (markerName) {
    // Find the marker by name and update details
    const allMarkers = [];
    if (typeof greenhouseMarkers !== 'undefined' && greenhouseMarkers) {
        allMarkers.push(...greenhouseMarkers);
    }
    if (typeof companyMarkers !== 'undefined' && companyMarkers) {
        allMarkers.push(...companyMarkers);
    }

    const marker = allMarkers.find(m => m.name === markerName);

    if (marker) {
        updateMarkerDetails(marker, marker.company ? 'company' : 'greenhouse');

        // If there's a sidebar toggle, trigger it
        const sidebarToggle = document.getElementById('sidebarToggleDetail');
        if (sidebarToggle) {
        console.log(sidebarToggle)
            sidebarToggle.click();
        }
    }
};

// Enhanced tab event listeners
document.addEventListener('DOMContentLoaded', function () {
    const greenhouseTab = document.querySelector('#greenhouseTab');
    const companyTab = document.querySelector('#companyTab');

    if (greenhouseTab) {
        greenhouseTab.addEventListener('click', function (event) {
            event.preventDefault();
            if (currentTab !== 'greenhouse') {
                if (typeof greenhouseMarkers !== 'undefined' && greenhouseMarkers) {
                    renderMarkers('greenhouse', greenhouseMarkers);
                }

                // Trigger Livewire event if available
                if (typeof Livewire !== 'undefined' && Livewire.emit) {
                    Livewire.emit('tabChanged', 'greenhouse');
                }
            }
        });
    }

    if (companyTab) {
        companyTab.addEventListener('click', function (event) {
            event.preventDefault();
            if (currentTab !== 'company') {
                const markers = (typeof companyMarkers !== 'undefined' && companyMarkers) ? companyMarkers : [];
                renderMarkers('company', markers);

                // Trigger Livewire event if available
                if (typeof Livewire !== 'undefined' && Livewire.emit) {
                    Livewire.emit('tabChanged', 'company');
                }
            }
        });
    }
});

// Map utility functions
const mapUtils = {
    // Fit map to show all markers
    fitToMarkers: function () {
        const activeLayer = currentTab === 'greenhouse' ? greenhouseMarkerLayer : companyMarkerLayer;
        if (activeLayer.getLayers().length > 0) {
            const group = new L.featureGroup(activeLayer.getLayers());
            map.fitBounds(group.getBounds().pad(0.1));
        }
    },

    // Go to specific marker
    goToMarker: function (markerInfo, zoom = 14) {
        map.setView(markerInfo.coordinates, zoom, {animate: true});

        // Find and open the marker popup
        const activeLayer = currentTab === 'greenhouse' ? greenhouseMarkerLayer : companyMarkerLayer;
        activeLayer.eachLayer(function (marker) {
            if (marker.markerInfo && marker.markerInfo.name === markerInfo.name) {
                marker.openPopup();
            }
        });
    },

    // Search markers by name or location
    searchMarkers: function (query) {
        const allMarkers = [];
        if (currentTab === 'greenhouse' && typeof greenhouseMarkers !== 'undefined' && greenhouseMarkers) {
            allMarkers.push(...greenhouseMarkers);
        } else if (currentTab === 'company' && typeof companyMarkers !== 'undefined' && companyMarkers) {
            allMarkers.push(...companyMarkers);
        }

        return allMarkers.filter(marker =>
            marker.name.includes(query) ||
            marker.area.includes(query) ||
            (marker.product && marker.product.includes(query))
        );
    }
};

// Add search functionality
window.searchMap = function (query) {
    const results = mapUtils.searchMarkers(query);
    if (results.length > 0) {
        // Focus on first result
        mapUtils.goToMarker(results[0]);
        updateMarkerDetails(results[0], currentTab);
    }
    return results;
};

// Performance optimizations
const performance = {
    // Debounce function for filter changes
    debounce: function (func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Throttle function for scroll/zoom events
    throttle: function (func, limit) {
        let inThrottle;
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
};

// Add event listeners for better UX
map.on('zoomend', performance.throttle(function () {
    // Update UI based on zoom level
    const zoom = map.getZoom();
    const mapContainer = document.getElementById('map');

    if (mapContainer) {
        if (zoom > 10) {
            mapContainer.classList.add('high-zoom');
        } else {
            mapContainer.classList.remove('high-zoom');
        }
    }
}, 250));

// Error handling for marker loading
window.addEventListener('error', function (e) {
    if (e.filename && e.filename.includes('map')) {
        console.warn('Map error caught:', e.message);
        // Fallback behavior - just log the error
    }
});

// Initialize the map with default markers when data is available
if (typeof greenhouseMarkers !== 'undefined' || typeof companyMarkers !== 'undefined') {
    showDefaultTabMarkers();
} else {
    // Wait for data to be available
    document.addEventListener('livewire:init', () => {
        showDefaultTabMarkers();
    });
}

// Export utility functions for external use
window.mapUtils = mapUtils;
window.updateMapMarkers = renderMarkers;
window.getCurrentTab = () => currentTab;

// Add CSS styles for modern markers and popups
const mapStyles = document.createElement('style');
mapStyles.textContent = `
    /* Custom Marker Styles */
    .custom-marker {
        position: relative;
        width: 40px;
        height: 40px;
        cursor: pointer;
    }

    .marker-inner {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .greenhouse-marker .marker-inner {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .company-marker .marker-inner {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }

    .marker-pulse {
        position: absolute;
        top: 4px;
        left: 4px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        animation: pulse 2s infinite;
        opacity: 0.6;
    }

    .greenhouse-marker .marker-pulse {
        background: #10b981;
    }

    .company-marker .marker-pulse {
        background: #3b82f6;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.6;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.3;
        }
        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    .custom-marker:hover .marker-inner,
    .marker-hover .marker-inner {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    /* Modern Popup Styles */
    .leaflet-popup-content-wrapper {
        background: white;
        border-radius: 16px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        padding: 0;
        overflow: hidden;
    }

    .leaflet-popup-content {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .leaflet-popup-tip {
        background: white;
        border: 1px solid #e2e8f0;
    }

    .modern-popup {
        padding: 20px;
        max-width: 280px;
    }

    .popup-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .popup-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .popup-icon.greenhouse {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .popup-icon.company {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .popup-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        line-height: 1.3;
    }

    .popup-type {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .popup-content {
        margin-bottom: 16px;
    }

    .popup-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 14px;
        color: #475569;
    }

    .popup-info:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 16px;
        height: 16px;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .popup-actions {
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }

    .popup-button {
        display: flex;
        align-items: center;
        gap: 6px;
        width: 100%;
        padding: 10px 16px;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s ease;
        justify-content: center;
    }

    .popup-button:hover {
        background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Details Panel Styles */
    .marker-details-modern {
        padding: 24px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .details-header {
        margin-bottom: 24px;
    }

    .details-image {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .details-image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .image-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
    }

    .marker-type-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
    }

    .marker-type-badge.greenhouse {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .marker-type-badge.company {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .details-title h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.3;
    }

    .info-section {
        margin-bottom: 24px;
    }

    .info-section h5 {
        margin: 0 0 16px 0;
        font-size: 16px;
        font-weight: 600;
        color: #334155;
    }

    .info-grid {
        display: grid;
        gap: 12px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .info-item .info-icon {
        width: 20px;
        height: 20px;
        color: #64748b;
        flex-shrink: 0;
    }

    .info-label {
        font-weight: 500;
        color: #64748b;
        min-width: 60px;
    }

    .info-value {
        color: #1e293b;
        font-weight: 500;
    }

    .divider {
        height: 1px;
        background: #e2e8f0;
        margin: 24px 0;
    }

    .automation-info {
        padding: 16px;
        background: #f1f5f9;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
    }

    .automation-info p {
        margin: 0 0 8px 0;
        color: #475569;
        font-weight: 500;
    }

    .automation-info p:last-child {
        margin-bottom: 0;
    }

    .environmental-grid {
        display: grid;
        gap: 16px;
        padding-bottom: 50px;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .env-card {
        padding: 16px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .env-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        font-weight: 600;
        color: #334155;
    }

    .env-icon {
        width: 20px;
        height: 20px;
        color: #64748b;
    }

    .env-values {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .env-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .env-label {
        font-size: 14px;
        color: #64748b;
    }

    .env-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    /* Map container enhancements */
    #map {
        transition: all 0.3s ease;
    }

    #map.high-zoom .leaflet-marker-icon {
        transform: scale(1.1);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modern-popup {
            padding: 16px;
            max-width: 260px;
        }

        .marker-details-modern {
            padding: 16px;
        }

        .environmental-grid {
            grid-template-columns: 1fr;
        }

        .info-grid {
            gap: 8px;
        }

        .info-item {
            padding: 10px;
        }
    }
`;

document.head.appendChild(mapStyles);
