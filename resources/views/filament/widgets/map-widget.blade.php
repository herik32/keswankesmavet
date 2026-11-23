<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Peta Sebaran Lokasi RPH/TPH Kalimantan Barat
        </x-slot>

        <div x-data="{
                locations: {{ json_encode($this->getTempatPemotonganData()) }},
                map: null,

                // Fungsi untuk memberikan warna
                colorMap: {
                    'PONTIANAK': '#ef4444',
                    'SINGKAWANG': '#f97316',
                    'KUBU RAYA': '#f59e0b',
                    'MEMPAWAH': '#10b981',
                    'SAMBAS': '#06b6d4',
                    'BENGKAYANG': '#3b82f6',
                    'LANDAK': '#6366f1',
                    'SANGGAU': '#8b5cf6',
                    'SEKADAU': '#a855f7',
                    'SINTANG': '#ec4899',
                    'MELAWI': '#14b8a6',
                    'KAPUAS HULU': '#84cc16',
                    'KAYONG UTARA': '#eab308',
                    'KETAPANG': '#64748b'
                },

                // Fungsi untuk mengambil nama kabupaten secara fleksibel
                getKabupatenName(properties) {
                    if (!properties) return '';
                    return properties.NAME_2 || '';
                },

                // Fungsi untuk memberikan warna dari colorMap
                getColor(name) {
                    if (!name) return '#9ca3af';
                    
                    // Standardisasi teks ke huruf kapital tanpa spasi berlebih
                    const cleanName = name.toString().toUpperCase().trim();

                    // Cari pencocokan nama
                    for (const key in this.colorMap) {
                        if (cleanName.includes(key) || key.includes(cleanName)) {
                            return this.colorMap[key];
                        }
                    }

                    return '#9ca3af';
                },
                
                async init() {
                    // Load CSS Leaflet
                    if (!document.getElementById('leaflet-css')) {
                        const link = document.createElement('link');
                        link.id = 'leaflet-css';
                        link.rel = 'stylesheet';
                        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                        document.head.appendChild(link);
                    }

                    // Load JS Leaflet
                    if (typeof L === 'undefined') {
                        await new Promise((resolve) => {
                            const script = document.createElement('script');
                            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                            script.onload = resolve;
                            document.head.appendChild(script);
                        });
                    }

                    this.$nextTick(() => {
                        this.renderMap();
                    });
                },

                async renderMap() {
                    if (this.map !== null) {
                        this.map.remove();
                    }

                    this.map = L.map(this.$refs.mapContainer).setView([-0.5322, 111.0969], 7);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 18
                    }).addTo(this.map);

                    // Json Kalbar
                    try {
                        const response = await fetch('/js/kalbar.json');
                        if (response.ok) {
                            const geojsonData = await response.json();
                            
                            L.geoJSON(geojsonData, {
                                style: (feature) => {
                                    // Ambil nama kabupaten dari atribut geojson
                                    const kabName = this.getKabupatenName(feature.properties);
                                    const regionColor = this.getColor(kabName);
                                    
                                    return {
                                        color: '#374151',
                                        weight: 1.5,
                                        opacity: 0.8,
                                        fillColor: regionColor,
                                        fillOpacity: 0.45
                                    };
                                },
                                onEachFeature: (feature, layer) => {
                                    // Tampilkan popup
                                    if (feature.properties && feature.properties.nama_kabupaten) {
                                        layer.bindPopup(`<b>${feature.properties.nama_kabupaten}</b>`);
                                    }
                                }
                            }).addTo(this.map);
                        }
                    } catch (error) {
                        console.error('Gagal memuat GeoJSON Kalbar:', error);
                    }

                    // Tampilan marker
                    let bounds = [];
                    this.locations.forEach(loc => {
                        if (loc.lat && loc.lng) {
                            const marker = L.marker([loc.lat, loc.lng]).addTo(this.map);
                            
                            const popupContent = `
                                <div class='p-1'>
                                    <strong style='font-size: 14px; color: #1f2937;'>${loc.nama}</strong>
                                </div>
                            `;
                            marker.bindPopup(popupContent);
                            bounds.push([loc.lat, loc.lng]);
                        }
                    });

                    setTimeout(() => {
                        this.map.invalidateSize();
                    }, 400);
                }
            }" wire:ignore class="w-full">
            <div x-ref="mapContainer" style="height: 500px; width: 100%; min-height: 500px;"
                class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 relative z-0"></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>