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

// Simplified custom marker icons
const createCustomIcon = (type) => {
    const iconConfig = {
        greenhouse: {
            html: `
                <div class="custom-marker greenhouse-marker">
                    <div class="marker-inner">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="marker-pulse"></div>
                </div>
            `,
            className: 'greenhouse-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 35],
            popupAnchor: [0, -35]
        },
        company: {
            html: `
                <div class="custom-marker company-marker">
                    <div class="marker-inner">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="marker-pulse"></div>
                </div>
            `,
            className: 'company-icon',
            iconSize: [40, 40],
            iconAnchor: [20, 35],
            popupAnchor: [0, -35]
        }
    };

    return L.divIcon(iconConfig[type]);
};

// Fallback to simple colored circle icons if custom icons fail
const createFallbackIcon = (type) => {
    const color = type === 'greenhouse' ? '#10b981' : '#3b82f6';

    return L.divIcon({
        html: `<div style="
            width: 24px;
            height: 24px;
            background: ${color};
            border: 3px solid white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        "></div>`,
        className: 'simple-marker',
        iconSize: [24, 24],
        iconAnchor: [12, 12],
        popupAnchor: [0, -12]
    });
};

// Layer groups for different marker types
let greenhouseMarkerLayer = L.layerGroup().addTo(map);
let companyMarkerLayer = L.layerGroup();

// Current active tab state
let currentTab = 'greenhouse';

// Enhanced marker rendering
function renderMarkers(type, markers) {
    console.log(`🗺️ Rendering ${type} markers:`, markers.length);

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

    console.log(`✅ ${type} markers rendered successfully`);
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
}

// Enhanced popup creation with modern styling
function createModernPopup(markerInfo, type) {
    const isCompany = type === 'company' || markerInfo.company;

    return `
        <div class="modern-popup" dir="rtl">
            <div class="popup-header">
                <div class="popup-icon ${isCompany ? 'company' : 'greenhouse'}">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
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
                            <path fill-rule="evenodd" d="M5.535 7.677c.313-.98.687-2.023.926-2.677H17.46c.253.63.646 1.64.977 2.61.166.487.312.953.416 1.347.11.42.148.675.148.779 0 .18-.032.355-.09.515-.06.161-.144.3-.243.412-.1.111-.21.192-.324.245a.809.809 0 0 1-.686 0 1.004 1.004 0 0 1-.324-.245c-.1-.112-.183-.25-.242-.412a1.473 1.473 0 0 1-.091-.515 1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.401 1.401 0 0 1 13 9.736a1 1 0 1 0-2 0 1.4 1.4 0 0 1-.333.927.896.896 0 0 1-.667.323.896.896 0 0 1-.667-.323A1.4 1.4 0 0 1 9 9.74v-.008a1 1 0 0 0-2 .003v.008a1.504 1.504 0 0 1-.18.712 1.22 1.22 0 0 1-.146.209l-.007.007a1.01 1.01 0 0 1-.325.248.82.82 0 0 1-.316.08.973.973 0 0 1-.563-.256 1.224 1.224 0 0 1-.102-.103A1.518 1.518 0 0 1 5 9.724v-.006a2.543 2.543 0 0 1 .029-.207c.024-.132.06-.296.11-.49.098-.385.237-.85.395-1.344ZM4 12.112a3.521 3.521 0 0 1-1-2.376c0-.349.098-.8.202-1.208.112-.441.264-.95.428-1.46.327-1.024.715-2.104.958-2.767A1.985 1.985 0 0 1 6.456 3h11.01c.803 0 1.539.481 1.844 1.243.258.641.67 1.697 1.019 2.72a22.3 22.3 0 0 1 .457 1.487c.114.433.214.903.214 1.286 0 .412-.072.821-.214 1.207A3.288 3.288 0 0 1 20 12.160V19a2 2 0 0 1-2 2h-6a1 1 0 0 1-1-1v-4H8v4a1 1 0 0 1-1 1H6a2 2 0 0 1-2-2v-6.888ZM13 15a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2Z" clip-rule="evenodd"/>
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
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    جزئیات بیشتر
                </button>
            </div>
        </div>
    `;
}

// Enhanced marker definition
function defineMarkersAndInfo(markersObj, markerLayer, type) {
    if (!markersObj || !Array.isArray(markersObj)) {
        console.warn('⚠️ Invalid markers data:', markersObj);
        return;
    }

    console.log(`🔧 Creating ${markersObj.length} ${type} markers`);

    markersObj.forEach(function (markerInfo, index) {
        try {
            // Try custom icon first, fallback to simple icon if it fails
            let customIcon;
            try {
                customIcon = createCustomIcon(type);
            } catch (error) {
                console.warn('⚠️ Custom icon failed, using fallback:', error);
                customIcon = createFallbackIcon(type);
            }

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
        } catch (error) {
            console.error(`❌ Failed to create marker ${index}:`, error, markerInfo);
        }
    });

    console.log(`✅ Successfully created ${markerLayer.getLayers().length} markers`);
}

// Enhanced marker details
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

                ${!isCompany && markerInfo.climateAutomation ? `
                    <div class="info-section">
                        <h5>سیستم اتوماسیون اقلیم</h5>
                        <div class="automation-info">
                            <p>${markerInfo.climateAutomation}</p>
                        </div>
                    </div>
                ` : ''}

                ${!isCompany && markerInfo.feedingAutomation ? `
                    <div class="info-section">
                        <h5>سیستم اتوماسیون تغذیه</h5>
                        <div class="automation-info">
                            <p>${markerInfo.feedingAutomation}</p>
                        </div>
                    </div>
                ` : ''}

                ${isCompany && markerInfo.website ? `
                    <div class="info-section">
                        <h5>وب سایت</h5>
                        <div class="automation-info" dir="ltr">
                            <a href="${markerInfo.website}" target="_blank">${markerInfo.website}</a>
                        </div>
                    </div>
                ` : ''}

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

// Global function for opening marker details
window.openMarkerDetails = function (markerName) {
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
            sidebarToggle.click();
        }
    }
};

// Map utility functions
const mapUtils = {
    fitToMarkers: function () {
        const activeLayer = currentTab === 'greenhouse' ? greenhouseMarkerLayer : companyMarkerLayer;
        if (activeLayer.getLayers().length > 0) {
            const group = new L.featureGroup(activeLayer.getLayers());
            map.fitBounds(group.getBounds().pad(0.1));
        }
    },

    goToMarker: function (markerInfo, zoom = 14) {
        map.setView(markerInfo.coordinates, zoom, {animate: true});

        const activeLayer = currentTab === 'greenhouse' ? greenhouseMarkerLayer : companyMarkerLayer;
        activeLayer.eachLayer(function (marker) {
            if (marker.markerInfo && marker.markerInfo.name === markerInfo.name) {
                marker.openPopup();
            }
        });
    },

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
        mapUtils.goToMarker(results[0]);
        updateMarkerDetails(results[0], currentTab);
    }
    return results;
};

// Initialize the map with default markers when data is available
if (typeof greenhouseMarkers !== 'undefined' || typeof companyMarkers !== 'undefined') {
    showDefaultTabMarkers();
} else {
    document.addEventListener('livewire:init', () => {
        showDefaultTabMarkers();
    });
}

// Export utility functions for external use
window.mapUtils = mapUtils;
window.updateMapMarkers = renderMarkers;
window.getCurrentTab = () => currentTab;

// Enhanced error handling and debugging
window.addEventListener('error', function (e) {
    if (e.filename && e.filename.includes('map')) {
        console.warn('Map error caught:', e.message);
    }
});

// Debug function to check marker creation
window.debugMarkers = function () {
    console.log('=== MARKER DEBUG INFO ===');
    console.log('Current tab:', currentTab);
    console.log('Greenhouse markers available:', typeof greenhouseMarkers !== 'undefined' && greenhouseMarkers ? greenhouseMarkers.length : 'None');
    console.log('Company markers available:', typeof companyMarkers !== 'undefined' && companyMarkers ? companyMarkers.length : 'None');
    console.log('Greenhouse layer count:', greenhouseMarkerLayer.getLayers().length);
    console.log('Company layer count:', companyMarkerLayer.getLayers().length);
    console.log('Map has greenhouse layer:', map.hasLayer(greenhouseMarkerLayer));
    console.log('Map has company layer:', map.hasLayer(companyMarkerLayer));

    // Test icon creation
    try {
        const testIcon = createCustomIcon('greenhouse');
        console.log('Custom icon creation: SUCCESS');
    } catch (error) {
        console.log('Custom icon creation: FAILED', error);
        try {
            const fallbackIcon = createFallbackIcon('greenhouse');
            console.log('Fallback icon creation: SUCCESS');
        } catch (fallbackError) {
            console.log('Fallback icon creation: FAILED', fallbackError);
        }
    }
    console.log('========================');
};
