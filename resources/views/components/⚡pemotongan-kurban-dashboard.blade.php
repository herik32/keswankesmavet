<?php

use App\Models\PemotonganKurban;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public $thn;
    public $kab = 'ALL';
    public $jns = 'ALL';

    public function mount()
    {
        $this->thn = DB::table('pemotongan_kurbans')->max('tahun') ?? date('Y');
    }

    public function updatedThn()
    {
        $this->resetPage();
        $this->dispatch('update-peta-data', ['mapData' => $this->getMapData()]);
        $this->dispatch('update-sebaran-chart', $this->getSebaranChartData());
        $this->dispatch('update-proporsi-chart', $this->getProporsiChartData());
    }

    public function updatedKab()
    {
        $this->resetPage();
        $this->dispatch('update-tren-chart', $this->getTrenChartData());
        $this->dispatch('update-proporsi-chart', $this->getProporsiChartData());
    }

    private function kabupatenFilter($query)
    {
        return $query->when($this->kab !== 'ALL', function ($q) {
            $q->where('kabupaten_id', $this->kab);
        });
    }

    public function getMapData()
    {
        return $this->kabupatenFilter(PemotonganKurban::where('tahun', $this->thn))
            ->with('kabupaten')
            ->select(
                'kabupaten_id',
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Sapi' THEN jumlah_pemotongan ELSE 0 END) as sapi"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kambing' THEN jumlah_pemotongan ELSE 0 END) as kambing"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Domba' THEN jumlah_pemotongan ELSE 0 END) as domba"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kerbau' THEN jumlah_pemotongan ELSE 0 END) as kerbau")
            )
            ->groupBy('kabupaten_id')
            ->get()
            ->keyBy('kabupaten_id')
            ->toArray();
    }

    public function getTrenChartData()
    {
        $trenQuery = $this->kabupatenFilter(PemotonganKurban::query())
            ->select(
                'tahun',
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Sapi' THEN jumlah_pemotongan ELSE 0 END) as sapi"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kambing' THEN jumlah_pemotongan ELSE 0 END) as kambing"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Domba' THEN jumlah_pemotongan ELSE 0 END) as domba"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kerbau' THEN jumlah_pemotongan ELSE 0 END) as kerbau")
            )
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->limit(10)
            ->get()
            ->sortBy('tahun')
            ->values();

        return [
            'categories' => $trenQuery->pluck('tahun')->map(fn($v) => (string) $v)->toArray(),
            'sapi'       => $trenQuery->pluck('sapi')->map(fn($v) => (int) $v)->toArray(),
            'kambing'    => $trenQuery->pluck('kambing')->map(fn($v) => (int) $v)->toArray(),
            'domba'      => $trenQuery->pluck('domba')->map(fn($v) => (int) $v)->toArray(),
            'kerbau'     => $trenQuery->pluck('kerbau')->map(fn($v) => (int) $v)->toArray(),
        ];
    }

    public function getSebaranChartData()
    {
        $sebaranQuery = $this->kabupatenFilter(PemotonganKurban::where('tahun', $this->thn))
            ->join('kabupatens', 'pemotongan_kurbans.kabupaten_id', '=', 'kabupatens.id')
            ->select(
                'kabupatens.nama as kabupaten',
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Sapi' THEN jumlah_pemotongan ELSE 0 END) as sapi"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kambing' THEN jumlah_pemotongan ELSE 0 END) as kambing"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Domba' THEN jumlah_pemotongan ELSE 0 END) as domba"),
                DB::raw("SUM(CASE WHEN jenis_ternak = 'Kerbau' THEN jumlah_pemotongan ELSE 0 END) as kerbau")
            )
            ->groupBy('kabupatens.nama')
            ->get()
            ->values();

        return [
            'categories' => $sebaranQuery->pluck('kabupaten')->map(fn($v) => (string) $v)->toArray(),
            'sapi'       => $sebaranQuery->pluck('sapi')->map(fn($v) => (int) $v)->toArray(),
            'kambing'    => $sebaranQuery->pluck('kambing')->map(fn($v) => (int) $v)->toArray(),
            'domba'      => $sebaranQuery->pluck('domba')->map(fn($v) => (int) $v)->toArray(),
            'kerbau'     => $sebaranQuery->pluck('kerbau')->map(fn($v) => (int) $v)->toArray(),
        ];
    }

    public function getProporsiChartData()
    {
        $proporsiQuery = $this->kabupatenFilter(PemotonganKurban::where('tahun', $this->thn))
            ->select(
                'jenis_ternak',
                DB::raw("SUM(jumlah_pemotongan) as jumlah")
            )
            ->groupBy('jenis_ternak')
            ->get()
            ->values();

        return [
            'categories' => $proporsiQuery->pluck('jenis_ternak')->map(fn($v) => (string) $v)->toArray(),
            'jumlah'     => $proporsiQuery->pluck('jumlah')->map(fn($v) => (int) $v)->toArray(),
        ];
    }

    public function with()
    {
        // filter data
        $listTahun = DB::table('pemotongan_kurbans')->select('tahun')->distinct()->orderBy('tahun', 'desc')->limit(10)->pluck('tahun');
        $listKabupaten = DB::table('kabupatens')->select('id', 'nama')->orderBy('id', 'asc')->get();
        $listTernak = ['Sapi', 'Kambing', 'Domba', 'Kerbau'];

        // top card
        $topCardQuery = $this->kabupatenFilter(PemotonganKurban::where('tahun', $this->thn))
            ->select('jenis_ternak', DB::raw('SUM(jumlah_pemotongan) as total'))
            ->groupBy('jenis_ternak')
            ->pluck('total', 'jenis_ternak')
            ->toArray();

        $topCardData = [
            'sapi'    => $topCardQuery['Sapi'] ?? 0,
            'kambing' => $topCardQuery['Kambing'] ?? 0,
            'domba'   => $topCardQuery['Domba'] ?? 0,
            'kerbau'  => $topCardQuery['Kerbau'] ?? 0,
        ];

        // map
        $mapData = $this->getMapData();

        // line chart
        $trenData = $this->getTrenChartData();

        // bar chart
        $sebaranData = $this->getSebaranChartData();

        // donut chart
        $proporsiData = $this->getProporsiChartData();

        // table data
        $tableData = $this->kabupatenFilter(PemotonganKurban::where('tahun', $this->thn))
            ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', $this->jns))
            ->with('kabupaten')
            ->orderBy('kabupaten_id')
            ->paginate(10);

        // kirim data ke view
        return [
            'listTahun'           => $listTahun,
            'listKabupaten'       => $listKabupaten,
            'listTernak'          => $listTernak,
            'topCardData'         => $topCardData,
            'mapData'             => $mapData,
            'trenCategories'      => $trenData['categories'],
            'trenSapi'            => $trenData['sapi'],
            'trenKambing'         => $trenData['kambing'],
            'trenDomba'           => $trenData['domba'],
            'trenKerbau'          => $trenData['kerbau'],
            'sebaranCategories'   => $sebaranData['categories'],
            'sebaranSapi'         => $sebaranData['sapi'],
            'sebaranKambing'      => $sebaranData['kambing'],
            'sebaranDomba'        => $sebaranData['domba'],
            'sebaranKerbau'       => $sebaranData['kerbau'],
            'proporsiCategories'  => $proporsiData['categories'],
            'proporsiJumlah'      => $proporsiData['jumlah'],
            'tableData'           => $tableData
        ];
    }
};
?>

<div class="min-h-screen bg-slate-50 p-4 md:p-8 space-y-6">

    {{-- header & filter --}}
    <div
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-md rounded-xl shadow-sm border border-slate-200 px-4 py-3 sm:px-6 transition-all">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-slate-800 leading-tight">Dashboard Pemotongan Kurban
                    </h1>
                    <p class="text-slate-500 text-xs mt-0.75 hidden sm:block">Visualisasi Data Pemotongan Kurban
                        Kalimantan Barat</p>
                </div>
            </div>

            <div class="flex flex-row items-center gap-2 sm:gap-3 w-full lg:w-auto">
                {{-- Filter Tahun --}}
                <div class="flex-1 sm:w-36">
                    <select wire:model.live="thn"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        @foreach($listTahun as $thn)
                        <option value="{{ $thn }}">{{ $thn }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Kabupaten/Kota --}}
                <div class="flex-1 sm:w-56">
                    <select wire:model.live="kab"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        <option value="ALL">Semua Kab/Kota</option>
                        @foreach($listKabupaten as $kab)
                        <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>

    {{-- top card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- card sapi --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-rose-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Sapi</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['sapi'], 0, ',',
                        '.') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>
                <div class="p-3 rounded-xl text-amber-600">
                    <img src="{{ asset('img/cow.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card kambing --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-emerald-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Kambing</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['kambing'], 0, ',',
                        '.')
                        }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>

                <div class="p-3 rounded-xl text-emerald-600">
                    <img src="{{ asset('img/goat.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card domba --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-sky-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Domba</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['domba'], 0, ',',
                        '.') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>
                <!-- Gambar / Vektor Domba -->
                <div class="p-3 rounded-xl text-blue-600">
                    <img src="{{ asset('img/sheep.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card kerbau --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-amber-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Kerbau</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['kerbau'], 0, ',',
                        '.')
                        }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>
                <!-- Gambar / Vektor Kerbau -->
                <div class="p-3 rounded-xl text-purple-600">
                    <img src="{{ asset('img/buffalo.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>
    </div>

    {{-- map & line chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- map --}}
        <div
            class="lg:col-span-6 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Peta Sebaran Pemotongan Kurban</h3>
                </div>
            </div>
            <div class="w-full flex-1 min-h-[350px] sm:min-h-100 relative">
                <div wire:ignore id="map" class="w-full h-full rounded-lg border border-slate-100 z-0"></div>
            </div>
        </div>

        {{-- line chart --}}
        <div
            class="lg:col-span-6 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Tren Pemotongan Kurban</h3>
                </div>
            </div>
            <div class="w-full flex-1 min-h-70 sm:min-h-100">
                <div wire:ignore id="trenLineChart" class="h-full w-full"></div>
            </div>
        </div>

    </div>

    {{-- bar chart & donut chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- bar chart --}}
        <div
            class="lg:col-span-9 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Sebaran Pemotongan Kurban</h3>
                </div>
            </div>
            <div class="w-full flex-1 min-h-70 sm:min-h-100">
                <div wire:ignore id="sebaranBarChart" class="h-full w-full"></div>
            </div>
        </div>

        {{-- donut chart --}}
        <div
            class="lg:col-span-3 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-800">Proporsi Jenis Ternak</h3>
                </div>
            </div>
            <div class="w-full flex-1 min-h-70 sm:min-h-100">
                <div wire:ignore id="proporsiDonutChart" class="h-full w-full"></div>
            </div>
        </div>

    </div>

    {{-- table data --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div
            class="p-4 sm:p-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-base font-semibold text-slate-800">Tabel Rincian Pemotongan Kurban</h3>
            </div>

            <div class="w-full sm:w-48">
                <select wire:model.live="jns"
                    class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    <option value="ALL">Semua Ternak</option>
                    @foreach($listTernak as $ternak)
                    <option value="{{ $ternak }}">{{ $ternak }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 border-r border-slate-200 text-center">Tahun</th>
                        <th class="px-6 py-3 border-r border-slate-200 text-center">Kabupaten/Kota</th>
                        <th class="px-6 py-3 border-r border-slate-200 text-center">Jenis Ternak</th>
                        <th class="px-6 py-3 border-r border-slate-200 text-center">Jumlah Pemotongan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($tableData as $row)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-2 border-r border-slate-200 font-medium text-slate-800 text-center">{{
                            $row->tahun }}
                        </td>
                        <td class="px-6 py-2 border-r border-slate-200">{{ $row->kabupaten->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-2 border-r border-slate-200 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $row->jenis_ternak === 'Sapi' ? 'bg-rose-100 text-rose-800' : '' }}
                            {{ $row->jenis_ternak === 'Kambing' ? 'bg-emerald-100 text-emerald-800' : '' }}
                            {{ $row->jenis_ternak === 'Domba' ? 'bg-sky-100 text-sky-800' : '' }}
                            {{ $row->jenis_ternak === 'Kerbau' ? 'bg-amber-100 text-amber-800' : '' }}">
                                {{ $row->jenis_ternak }}
                            </span>
                        </td>
                        <td class="px-6 py-2 border-r border-slate-200 text-right font-semibold text-slate-800">{{
                            number_format($row->jumlah_pemotongan, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-slate-400">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200">
            {{ $tableData->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>

@script
<script>
    // map
    let dbData = @json($mapData ?? []);
    let geojsonLayer;
    let rawGeojsonData;

    let map = L.map('map', {
        fullscreenControl: true,
        fullscreenControlOptions: {
            position: 'topleft'
        }
    }).setView([-0.5322, 111.0969], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18
    }).addTo(map);

    const kabupatenColors = {
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
    };

    function getKabupatenColor(namaKabupaten) {
        if (!namaKabupaten) return '#cbd5e1';
        let cleanName = String(namaKabupaten).toUpperCase();
        return kabupatenColors[cleanName] || '#cbd5e1';
    }

    fetch('/js/kalbar.json')
        .then(res => res.json())
        .then(data => {
            rawGeojsonData = data;
            renderMap();
        });

    // Event listener saat ada perubahan filter dari Livewire
    Livewire.on('update-peta-data', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;
        dbData = payload.mapData || {};
        if (rawGeojsonData) {
            renderMap();
        }
    });

    function renderMap() {
        if (geojsonLayer) {
            map.removeLayer(geojsonLayer);
        }

        geojsonLayer = L.geoJson(rawGeojsonData, {
            coordsToLatLng: function(coords) {
                if (coords[0] >= 90 || coords[0] <= -90) {
                    return new L.LatLng(coords[1], coords[0]);
                }
                return new L.LatLng(coords[0], coords[1]);
            },

            style: function(feature) {
                let kabId = String(feature.properties.CC_2);
                let item = dbData[kabId] || null;
                let namaKab = feature.properties.NAME_2;

                return {
                    fillColor: getKabupatenColor(namaKab),
                    weight: 1.5,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.75
                };
            },

            onEachFeature: function(feature, layer) {
                let kabId = String(feature.properties.CC_2);
                let namaKabGeoJSON = feature.properties.NAME_2;
                let item = dbData[kabId] || null;

                let popupContent = `
                    <div class="p-1 w-full min-w-[260px]">
                        <h4 class="font-bold text-slate-800 text-sm border-b pb-1 mb-2">${namaKabGeoJSON}</h4>
                        ${item ? `
                        <div class="text-xs space-y-1.5">
                            <div class="flex justify-between items-center gap-4 whitespace-nowrap"><span class="text-slate-500">🐄 Sapi:</span><b class="text-rose-500">${Number(item.sapi).toLocaleString('id-ID')} Ekor</b></div>
                            <div class="flex justify-between items-center gap-4 whitespace-nowrap"><span class="text-slate-500">🐐 Kambing:</span><b class="text-emerald-500">${Number(item.kambing).toLocaleString('id-ID')} Ekor</b></div>
                            <div class="flex justify-between items-center gap-4 whitespace-nowrap"><span class="text-slate-500">🐑 Domba:</span><b class="text-sky-500">${Number(item.domba).toLocaleString('id-ID')} Ekor</b></div>
                            <div class="flex justify-between items-center gap-4 whitespace-nowrap"><span class="text-slate-500">🐃 Kerbau:</span><b class="text-amber-500">${Number(item.kerbau).toLocaleString('id-ID')} Ekor</b></div>
                            <div class="flex justify-between items-center gap-4 whitespace-nowrap"><span class="text-slate-500">Total Pemotongan:</span><b>${(Number(item.sapi)+Number(item.kambing)+Number(item.domba)+Number(item.kerbau)).toLocaleString('id-ID')} Ekor</b></div>
                        </div>
                        ` : `
                            <p class="text-xs text-slate-400 italic">Data tidak ditemukan.</p>
                        `}
                    </div>
                `;

                layer.bindPopup(popupContent, {
                    minWidth: 280,
                    maxWidth: 400
                });

                layer.on({
                    mouseover: (e) => {
                        let l = e.target;
                        l.setStyle({
                            fillOpacity: 0.9,
                            weight: 2.5,
                            color: '#0f172a'
                        });
                        l.bringToFront();
                    },
                    mouseout: (e) => {
                        geojsonLayer.resetStyle(e.target);
                    }
                });
            }
        }).addTo(map);

        window.addEventListener('load', () => {
            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        });

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });

        const mapContainer = document.getElementById('map');
        if (mapContainer) {
            const resizeObserver = new ResizeObserver(() => {
                map.invalidateSize();
            });
            resizeObserver.observe(mapContainer);
        }
    }

    // line chart
    let trenCategories = @json($trenCategories);
    let trenDataSapi = @json($trenSapi);
    let trenDataKambing = @json($trenKambing);
    let trenDataDomba = @json($trenDomba);
    let trenDataKerbau = @json($trenKerbau);

    let trenOptions = {
        chart: {
            type: 'line',
            height: 400,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            fontFamily: 'Inter, sans-serif'
        },
        stroke: {
            curve: 'smooth',
            width: [3, 3, 3, 3]
        },
        colors: ['#f43f5e', '#10b981', '#0284c7', '#f59e0b'],
        series: [{
                name: 'Sapi',
                data: trenDataSapi
            },
            {
                name: 'Kambing',
                data: trenDataKambing
            },
            {
                name: 'Domba',
                data: trenDataDomba
            },
            {
                name: 'Kerbau',
                data: trenDataKerbau
            }
        ],
        xaxis: {
            categories: trenCategories,
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '12px'
                }
            }
        },
        yaxis: [{
            seriesName: 'Pemotongan',
            title: {
                text: 'Jumlah Pemotongan (Ekor)',
                style: {
                    color: '#64748b',
                    fontWeight: 'normal'
                }
            },
            labels: {
                style: {
                    colors: '#64748b'
                },
                formatter: (val) => new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(val)
            }
        }],
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val, {
                    seriesIndex
                }) {
                    if (val === null || val === undefined) return '-';
                    let unit = ' Ekor';
                    return new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0
                    }).format(val) + unit;
                }
            }
        }
    };

    let lineChart = new ApexCharts(document.querySelector("#trenLineChart"), trenOptions);
    lineChart.render();

    $wire.on('update-tren-chart', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload) {
            lineChart.updateOptions({
                xaxis: {
                    categories: payload.categories
                },
                series: [{
                        name: 'Sapi',
                        data: payload.sapi
                    },
                    {
                        name: 'Kambing',
                        data: payload.kambing
                    },
                    {
                        name: 'Domba',
                        data: payload.domba
                    },
                    {
                        name: 'Kerbau',
                        data: payload.kerbau
                    }
                ]
            });
        }
    });

    // bar chart
    let sebaranCategories = @json($sebaranCategories);
    let sebaranDataSapi = @json($sebaranSapi);
    let sebaranDataKambing = @json($sebaranKambing);
    let sebaranDataDomba = @json($sebaranDomba);
    let sebaranDataKerbau = @json($sebaranKerbau);

    let sebaranOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: false
            },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '75%',
                borderRadius: 4
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        colors: ['#f43f5e', '#10b981', '#0284c7', '#f59e0b'],
        series: [{
                name: 'Sapi',
                data: sebaranDataSapi
            },
            {
                name: 'Kambing',
                data: sebaranDataKambing
            },
            {
                name: 'Domba',
                data: sebaranDataDomba
            },
            {
                name: 'Kerbau',
                data: sebaranDataKerbau
            }
        ],
        xaxis: {
            categories: sebaranCategories,
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '12px'
                }
            }
        },
        yaxis: [{
            seriesName: 'Pemotongan',
            title: {
                text: 'Jumlah Pemotongan (Ekor)',
                style: {
                    color: '#64748b',
                    fontWeight: 'normal'
                }
            },
            labels: {
                style: {
                    colors: '#64748b'
                },
                formatter: (val) => new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(val)
            }
        }],
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val, {
                    seriesIndex
                }) {
                    if (val === null || val === undefined) return '-';
                    let unit = ' Ekor';
                    return new Intl.NumberFormat('id-ID', {
                        maximumFractionDigits: 0
                    }).format(val) + unit;
                }
            }
        }
    };

    let barChart = new ApexCharts(document.querySelector("#sebaranBarChart"), sebaranOptions);
    barChart.render();

    $wire.on('update-sebaran-chart', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload) {
            barChart.updateOptions({
                xaxis: {
                    categories: payload.categories
                },
                series: [{
                        name: 'Sapi',
                        data: payload.sapi
                    },
                    {
                        name: 'Kambing',
                        data: payload.kambing
                    },
                    {
                        name: 'Domba',
                        data: payload.domba
                    },
                    {
                        name: 'Kerbau',
                        data: payload.kerbau
                    }
                ]
            });
        }
    });

    //donut chart
    let proporsiCategories = @json($proporsiCategories);
    let proporsiJumlah = @json($proporsiJumlah);

    let proporsiOptions = {
        chart: {
            type: 'donut',
            height: 450,
            fontFamily: 'Inter, sans-serif'
        },
        labels: proporsiCategories,
        series: proporsiJumlah,
        colors: ['#f43f5e', '#10b981', '#0284c7', '#f59e0b'],
        legend: {
            position: 'bottom',
            fontSize: '13px',
            fontFamily: 'Inter, sans-serif',
            labels: {
                colors: '#64748b'
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toFixed(1) + "%";
            }
        },
        tooltip: {
            y: {
                formatter: (val) => new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(val) + " Ekor"
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontFamily: 'Inter, sans-serif',
                            fontWeight: 600,
                            color: '#1e293b',
                            formatter: function(val) {
                                return new Intl.NumberFormat('id-ID', {
                                    maximumFractionDigits: 0
                                }).format(val) + " Ha";
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total Pemotongan',
                            fontSize: '12px',
                            color: '#64748b',
                            formatter: function(w) {
                                const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                return new Intl.NumberFormat('id-ID', {
                                    maximumFractionDigits: 0
                                }).format(total) + " Ekor";
                            }
                        }
                    }
                }
            }
        }
    };

    let donutChart = new ApexCharts(document.querySelector("#proporsiDonutChart"), proporsiOptions);
    donutChart.render();

    $wire.on('update-proporsi-chart', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload && payload.categories) {
            donutChart.updateOptions({
                labels: payload.categories,
                series: payload.jumlah
            });
        }
    });
</script>
@endscript