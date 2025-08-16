<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
      crossorigin=""/>

<!-- Custom Map Styles -->
<style>
    .map-container {
        height: 70vh;
        min-height: 500px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .location-popup {
        max-width: 300px;
    }
    .location-popup h3 {
        color: #1f2937;
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .service-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        margin: 2px;
    }
    .service-hotels { background-color: #fef3c7; color: #92400e; }
    .service-ferries { background-color: #dbeafe; color: #1e40af; }
    .service-themeparks { background-color: #dcfce7; color: #166534; }
    .filter-buttons {
        margin-bottom: 1rem;
    }
    .filter-btn {
        padding: 8px 16px;
        margin: 4px;
        border: 2px solid transparent;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .filter-btn.active {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    .filter-btn:not(.active) {
        background-color: white;
        color: #374151;
        border-color: #d1d5db;
    }
    .filter-btn:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .tropical-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .custom-marker {
        background: #3b82f6;
        border: 3px solid white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .custom-marker.hotels { background: #f59e0b; }
    .custom-marker.ferries { background: #3b82f6; }
    .custom-marker.themeparks { background: #10b981; }
    .custom-marker.multiple { background: linear-gradient(45deg, #f59e0b 33%, #3b82f6 33%, #3b82f6 66%, #10b981 66%); }
</style>

<div class="@if($layout === 'guest') @else p-6 @endif">
    <!-- Filter Buttons -->
    <div class="filter-buttons text-center">
        <button class="filter-btn active" data-filter="all">
            🗺️ All Locations
        </button>
        <button class="filter-btn" data-filter="hotels">
            🏨 Hotels
        </button>
        <button class="filter-btn" data-filter="ferries">
            ⛴️ Ferries
        </button>
        <button class="filter-btn" data-filter="themeparks">
            🎢 Theme Parks
        </button>
    </div>

    <!-- Map Container -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div id="map" class="map-container"></div>
    </div>

    <!-- Location Details Modal -->
    <div id="location-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Location Details</h3>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modal-content">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" 
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" 
        crossorigin=""></script>

<script>
    // Initialize map
    const map = L.map('map').setView([3.94028, 73.48889], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Custom icons
    const createCustomIcon = (type) => {
        let color = '#3b82f6';
        switch(type) {
            case 'hotels': color = '#f59e0b'; break;
            case 'ferries': color = '#3b82f6'; break;
            case 'themeparks': color = '#10b981'; break;
            case 'multiple': return L.divIcon({
                className: 'custom-marker multiple',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
        }
        return L.divIcon({
            className: `custom-marker ${type}`,
            iconSize: [20, 20],
            iconAnchor: [10, 10],
            html: `<div style="background: ${color}; width: 100%; height: 100%; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.3);"></div>`
        });
    };

    // Location data
    const locations = @json($locations);
    let markers = [];
    let currentFilter = 'all';

    // Create markers
    function createMarkers() {
        markers.forEach(marker => map.removeLayer(marker));
        markers = [];
        let bounds = L.latLngBounds();

        locations.forEach(location => {
            if (!location.latitude || !location.longitude) {
                console.warn(`Skipping location ${location.location_name}: Invalid coordinates`);
                return;
            }

            const hasHotels = location.hotels?.length > 0;
            const hasFerries = location.ferries?.length > 0;
            const hasThemeparks = location.themeparks?.length > 0;

            if (currentFilter !== 'all') {
                if (currentFilter === 'hotels' && !hasHotels) return;
                if (currentFilter === 'ferries' && !hasFerries) return;
                if (currentFilter === 'themeparks' && !hasThemeparks) return;
            }

            const serviceCount = [hasHotels, hasFerries, hasThemeparks].filter(Boolean).length;
            const markerType = serviceCount > 1 ? 'multiple' : hasHotels ? 'hotels' : hasFerries ? 'ferries' : hasThemeparks ? 'themeparks' : 'default';

            let popupContent = `
                <div class="location-popup">
                    <h3>${location.location_name}</h3>
                    <div class="mb-3">
                        ${hasHotels ? `<span class="service-badge service-hotels">🏨 ${location.hotels.length} Hotel(s)</span>` : ''}
                        ${hasFerries ? `<span class="service-badge service-ferries">⛴️ ${location.ferries.length} Ferry(s)</span>` : ''}
                        ${hasThemeparks ? `<span class="service-badge service-themeparks">🎢 ${location.themeparks.length} Theme Park(s)</span>` : ''}
                    </div>
                    <button onclick="showLocationDetails(${location.id})" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium w-full">
                        View Details & Book
                    </button>
                </div>
            `;

            const marker = L.marker([location.latitude, location.longitude], {
                icon: createCustomIcon(markerType)
            }).bindPopup(popupContent).addTo(map);
            markers.push(marker);
            bounds.extend([location.latitude, location.longitude]);
        });

        if (markers.length > 0) {
            map.fitBounds(bounds, {padding: [20, 20]});
        }
    }

    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            createMarkers();
        });
    });

    // Reset view button
    document.getElementById('reset-view')?.addEventListener('click', function() {
        map.setView([25.7617, -80.1918], 13);
        currentFilter = 'all';
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');
        createMarkers();
    });

    // Modal functionality
    function showLocationDetails(locationId) {
        const location = locations.find(l => l.id === locationId);
        if (!location) return;

        document.getElementById('modal-title').textContent = location.location_name;
        let modalContent = `
            <div class="space-y-6">
                <div class="border-b pb-4">
                    <p class="text-sm text-gray-500">Location Coordinates</p>
                    <p class="text-gray-900">${location.latitude}, ${location.longitude}</p>
                </div>
        `;

        if (location.hotels?.length > 0) {
            modalContent += `
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">🏨 Hotels (${location.hotels.length})</h4>
                    <div class="grid gap-3">
                        ${location.hotels.map(hotel => `
                            <div class="border rounded-lg p-3 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="font-medium text-gray-900">${hotel.name}</h5>
                                        ${hotel.description ? `<p class="text-sm text-gray-600 mt-1">${hotel.description}</p>` : ''}
                                        ${hotel.price_per_night ? `<p class="text-sm font-medium text-green-600 mt-2">From $${hotel.price_per_night}/night</p>` : ''}
                                    </div>
                                    <a href="${window.location.origin}/hotels/${hotel.id}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Book
                                    </a>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        if (location.ferries?.length > 0) {
            modalContent += `
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">⛴️ Ferries (${location.ferries.length})</h4>
                    <div class="grid gap-3">
                        ${location.ferries.map(ferry => `
                            <div class="border rounded-lg p-3 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="font-medium text-gray-900">${ferry.name}</h5>
                                        <p class="text-sm text-gray-600 mt-1">Capacity: ${ferry.capacity} passengers</p>
                                    </div>
                                    <a href="${window.location.origin}/ferries/${ferry.id}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Book
                                    </a>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        if (location.themeparks?.length > 0) {
            modalContent += `
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">🎢 Theme Parks (${location.themeparks.length})</h4>
                    <div class="grid gap-3">
                        ${location.themeparks.map(themepark => `
                            <div class="border rounded-lg p-3 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="font-medium text-gray-900">${themepark.name}</h5>
                                        ${themepark.description ? `<p class="text-sm text-gray-600 mt-1">${themepark.description}</p>` : ''}
                                    </div>
                                    <a href="${window.location.origin}/themeparks/${themepark.id}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                        Book
                                    </a>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        modalContent += `</div>`;
        document.getElementById('modal-content').innerHTML = modalContent;
        document.getElementById('location-modal').classList.remove('hidden');
    }

    document.getElementById('close-modal').addEventListener('click', function() {
        document.getElementById('location-modal').classList.add('hidden');
    });

    document.getElementById('location-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    // Initialize markers
    createMarkers();

    // Add map controls
    const legend = L.control({position: 'bottomright'});
    legend.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'legend');
        div.innerHTML = `
            <div style="background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div style="font-weight: bold; margin-bottom: 5px;">Legend</div>
                <div style="margin: 2px 0;"><span style="display: inline-block; width: 12px; height: 12px; background: #f59e0b; border-radius: 50%; margin-right: 5px;"></span> Hotels</div>
                <div style="margin: 2px 0;"><span style="display: inline-block; width: 12px; height: 12px; background: #3b82f6; border-radius: 50%; margin-right: 5px;"></span> Ferries</div>
                <div style="margin: 2px 0;"><span style="display: inline-block; width: 12px; height: 12px; background: #10b981; border-radius: 50%; margin-right: 5px;"></span> Theme Parks</div>
                <div style="margin: 2px 0;"><span style="display: inline-block; width: 12px; height: 12px; background: linear-gradient(45deg, #f59e0b 33%, #3b82f6 33%, #3b82f6 66%, #10b981 66%); border-radius: 50%; margin-right: 5px;"></span> Multiple Services</div>
            </div>
        `;
        return div;
    };
    legend.addTo(map);
</script>
