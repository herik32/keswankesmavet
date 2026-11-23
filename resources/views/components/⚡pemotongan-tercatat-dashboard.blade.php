<?php

use App\Models\Kabupaten;
use App\Models\PemotonganTercatat;
use App\Models\TempatPemotongan;
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
        $this->thn = DB::table('pemotongan_tercatats')
            ->selectRaw('MAX(LEFT(bulan, 4)) as max_tahun')
            ->value('max_tahun') ?? date('Y');
    }

    public function updatedThn()
    {
        $this->resetPage();
        $this->dispatchAllEvents();
    }

    public function updatedKab()
    {
        $this->resetPage();
        $this->dispatchAllEvents();
    }

    public function updatedJns()
    {
        $this->resetPage();
        $this->dispatchAllEvents();
    }

    private function dispatchAllEvents()
    {
        $this->dispatch('update-map-data', $this->getMapData());
        $this->dispatch('update-tren-chart', $this->getTrenChartData());
        $this->dispatch('update-bulan-bar-chart', $this->getBulanBarChartData());
        $this->dispatch('update-kab-bar-chart', $this->getKabBarChartData());
    }

    // Filter helper
    private function applyFilter($query)
    {
        return $query->when($this->kab !== 'ALL', function ($q) {
            $q->whereHas('tempatPemotongan', function ($target) {
                $target->where('kabupaten_id', $this->kab);
            });
        });
    }

    // map
    public function getMapData()
    {
        // marker
        $markers = [];

        if ($this->kab !== 'ALL') {
            $tempatPemotonganQuery = TempatPemotongan::query()
                ->where('kabupaten_id', $this->kab)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude');

            $markers = $tempatPemotonganQuery->get()->map(function ($tempat) {
                $totalPemotongan = PemotonganTercatat::query()
                    ->where('tempat_pemotongan_id', $tempat->id)
                    ->where('bulan', 'LIKE', $this->thn . '-%')
                    ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', 'LIKE', $this->jns . '%'))
                    ->sum('jumlah_pemotongan');

                return [
                    'id'        => $tempat->id,
                    'nama'      => $tempat->nama,
                    'lat'       => (float) $tempat->latitude,
                    'lng'       => (float) $tempat->longitude,
                    'total'     => (int) $totalPemotongan,
                ];
            })->toArray();
        }

        // ambil statistik akumulasi per kabupaten
        $statsQuery = DB::table('kabupatens')
            ->leftJoin('tempat_pemotongans', function ($join) {
                $join->on('kabupatens.id', '=', 'tempat_pemotongans.kabupaten_id')
                    ->where('tempat_pemotongans.status_aktif', true);
            })
            ->leftJoin('pemotongan_tercatats', function ($join) {
                $join->on('tempat_pemotongans.id', '=', 'pemotongan_tercatats.tempat_pemotongan_id')
                    ->where('pemotongan_tercatats.bulan', 'LIKE', $this->thn . '-%');

                if ($this->jns !== 'ALL') {
                    $join->where('pemotongan_tercatats.jenis_ternak', 'LIKE', $this->jns . '%');
                }
            })
            ->select(
                'kabupatens.id',
                'kabupatens.nama',
                DB::raw('COALESCE(SUM(pemotongan_tercatats.jumlah_pemotongan), 0) as total_pemotongan'),
                DB::raw('COUNT(DISTINCT tempat_pemotongans.id) as jumlah_tempat')
            )
            ->groupBy('kabupatens.id', 'kabupatens.nama')
            ->get();

        $kabupatenStats = [];
        foreach ($statsQuery as $item) {
            $kabupatenStats[$item->id] = [
                'total'         => (int) $item->total_pemotongan,
                'jumlah_tempat' => (int) $item->jumlah_tempat
            ];
        }

        return [
            'selectedKabupatenId' => $this->kab,
            'stats'               => $kabupatenStats,
            'markers'             => $markers,
        ];
    }

    // Line Chart
    public function getTrenChartData()
    {
        $trenData = $this->applyFilter(PemotonganTercatat::query())
            ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', 'LIKE', $this->jns . '%'))
            ->select(
                DB::raw("LEFT(bulan, 4) as tahun"),
                DB::raw("SUM(jumlah_pemotongan) as jumlah")
            )
            ->groupBy(DB::raw("LEFT(bulan, 4)"))
            ->orderBy(DB::raw("LEFT(bulan, 4)"), 'desc')
            ->limit(10)
            ->get()
            ->sortBy('tahun')
            ->values();

        return [
            'categories' => $trenData->pluck('tahun')->map(fn($v) => (string) $v)->toArray(),
            'jumlah'     => $trenData->pluck('jumlah')->map(fn($v) => (int) $v)->toArray(),
        ];
    }

    // Bar Chart Horizontal
    public function getBulanBarChartData()
    {
        $namaBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulanData = $this->applyFilter(
            PemotonganTercatat::query()->where('bulan', 'LIKE', $this->thn . '-%')
        )
            ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', 'LIKE', $this->jns . '%'))
            ->select(
                DB::raw('MONTH(bulan) as num_bulan'),
                DB::raw('SUM(jumlah_pemotongan) as total')
            )
            ->groupBy(DB::raw('MONTH(bulan)'))
            ->pluck('total', 'num_bulan');

        $categories = [];
        $jumlah = [];

        foreach ($namaBulan as $num => $nama) {
            $categories[] = $nama;
            $jumlah[] = (int) ($bulanData[$num] ?? 0);
        }

        return [
            'categories' => $categories,
            'jumlah'     => $jumlah,
        ];
    }

    // Bar Chart
    public function getKabBarChartData()
    {
        $kabupaten = Kabupaten::orderBy('nama', 'asc')->pluck('nama', 'id');

        $kabData = PemotonganTercatat::query()
            ->join('tempat_pemotongans', 'pemotongan_tercatats.tempat_pemotongan_id', '=', 'tempat_pemotongans.id')
            ->join('kabupatens', 'tempat_pemotongans.kabupaten_id', '=', 'kabupatens.id')
            ->where('pemotongan_tercatats.bulan', 'LIKE', $this->thn . '-%')
            ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', 'LIKE', $this->jns . '%'))
            ->select(
                'kabupatens.id',
                'kabupatens.nama as nama_kabupaten',
                DB::raw('SUM(pemotongan_tercatats.jumlah_pemotongan) as total')
            )
            ->groupBy('kabupatens.id', 'kabupatens.nama')
            ->orderBy('total', 'desc')
            ->pluck('total', 'id');

        $result = [];

        foreach ($kabupaten as $id => $namaKab) {
            $result[$namaKab] = (int) ($kabData[$id] ?? 0);
        }

        arsort($result);

        $categories = [];
        $dataJumlah = [];

        foreach ($result as $namaKab => $total) {
            $categories[] = $namaKab;
            $dataJumlah[] = $total;
        }

        return [
            'categories' => $categories,
            'jumlah'     => $dataJumlah,
        ];
    }

    public function with()
    {
        // Filter Data
        $listTahun = DB::table('pemotongan_tercatats')
            ->selectRaw('LEFT(bulan, 4) as thn')
            ->distinct()
            ->orderBy('thn', 'desc')
            ->limit(10)
            ->pluck('thn');
        $listKabupaten = DB::table('kabupatens')->select('id', 'nama')->orderBy('id', 'asc')->get();
        $listTernak    = ['Ayam', 'Babi', 'Kambing', 'Kerbau', 'Sapi'];

        // Top Card Data
        $topCardQuery = $this->applyFilter(PemotonganTercatat::where('bulan', 'LIKE', $this->thn . '-%'));

        $topCardTernak = (clone $topCardQuery)
            ->select(
                DB::raw("
            CASE 
                WHEN jenis_ternak = 'Ayam' THEN 'Ayam'
                WHEN jenis_ternak = 'Babi' THEN 'Babi'
                WHEN jenis_ternak = 'Kambing' THEN 'Kambing'
                WHEN jenis_ternak LIKE 'Kerbau%' THEN 'Kerbau'
                WHEN jenis_ternak LIKE 'Sapi%' THEN 'Sapi'
                ELSE jenis_ternak
            END as grup_ternak
        "),
                DB::raw('SUM(jumlah_pemotongan) as total')
            )
            ->groupBy('grup_ternak')
            ->pluck('total', 'grup_ternak');

        $totalRphAktif = TempatPemotongan::where('status_aktif', true)
            ->when($this->kab !== 'ALL', fn($q) => $q->where('kabupaten_id', $this->kab))
            ->count('id');

        $topCardData = [
            'ayam'      => $topCardTernak['Ayam'] ?? 0,
            'babi'      => $topCardTernak['Babi'] ?? 0,
            'sapi'      => $topCardTernak['Sapi'] ?? 0,
            'rph_tph'   => $totalRphAktif,
        ];

        // map
        $mapData = $this->getMapData();

        // line chart
        $trenData = $this->getTrenChartData();

        // horizontal bar chart
        $bulanBarData = $this->getBulanBarChartData();

        // bar chart
        $kabBarData = $this->getKabBarChartData();

        // Table Data
        $tableData = $this->applyFilter(PemotonganTercatat::where('bulan', 'LIKE', $this->thn . '-%'))
            ->when($this->jns !== 'ALL', fn($q) => $q->where('jenis_ternak', 'LIKE', $this->jns . '%'))
            ->with(['tempatPemotongan.kabupaten'])
            ->orderBy('bulan', 'asc')
            ->paginate(10);

        return [
            'listTahun'         => $listTahun,
            'listKabupaten'     => $listKabupaten,
            'listTernak'        => $listTernak,
            'topCardData'       => $topCardData,
            'mapDataKab'        => $mapData['selectedKabupatenId'],
            'mapDataStats'      => $mapData['stats'],
            'mapDataMarkers'    => $mapData['markers'],
            'trenCategories'    => $trenData['categories'],
            'trenJumlah'        => $trenData['jumlah'],
            'bulanCategories'   => $bulanBarData['categories'],
            'bulanJumlah'       => $bulanBarData['jumlah'],
            'kabCategories'     => $kabBarData['categories'],
            'kabJumlah'         => $kabBarData['jumlah'],
            'tableData'         => $tableData,
        ];
    }
};
?>

<div class="min-h-screen bg-slate-50 p-4 md:p-8 space-y-6">
    {{-- Header + Filter --}}
    <div
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-md rounded-xl shadow-sm border border-slate-200 px-4 py-3 sm:px-6 transition-all">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

            <div class="flex items-center gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-slate-800 leading-tight">Dashboard Pemotongan Tercatat
                    </h1>
                    <p class="text-slate-500 text-xs mt-0.75 hidden sm:block">Monitoring pemotongan hewan tercatat di
                        RPH/TPH</p>
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

                {{-- Filter Jenis ternak --}}
                <div class="flex-1 sm:w-56">
                    <select wire:model.live="jns"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-xs sm:text-sm rounded-lg px-2.5 py-1.5 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        <option value="ALL">Semua Ternak</option>
                        @foreach($listTernak as $jt)
                        <option value="{{ $jt }}">{{ $jt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
    </div>

    {{-- Top Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- card ayam --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-rose-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Ayam</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['ayam'], 0, ',',
                        '.') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>
                <div class="p-3 rounded-xl text-amber-600">
                    <img src="{{ asset('img/chicken.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card kambing --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-emerald-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Babi</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['babi'], 0, ',',
                        '.')
                        }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>

                <div class="p-3 rounded-xl text-emerald-600">
                    <img src="{{ asset('img/pig.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card domba --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-sky-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pemotongan Sapi</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['sapi'], 0, ',',
                        '.') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">Ekor</p>
                </div>
                <!-- Gambar / Vektor Domba -->
                <div class="p-3 rounded-xl text-blue-600">
                    <img src="{{ asset('img/cow.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>

        {{-- card kerbau --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-slate-200 px-5 py-2 border-l-4 border-l-amber-500 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">RPH/TPH Aktif</p>
                    <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ number_format($topCardData['rph_tph'], 0, ',',
                        '.')
                        }}</h3>
                    <p class="text-xs text-slate-400 mt-1">Unit</p>
                </div>
                <!-- Gambar / Vektor Kerbau -->
                <div class="p-3 rounded-xl text-purple-600">
                    <img src="{{ asset('img/rph.png') }}" class="w-20 h-20 object-contain">
                </div>
            </div>
        </div>
    </div>

    {{-- Peta Sebaran Pemotongan --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="text-base font-semibold text-slate-800">Peta Sebaran Pemotongan Tercatat</h3>
        </div>
        <div class="w-full h-[400px] sm:h-[500px] relative">
            <div wire:ignore id="map" class="w-full h-full rounded-lg border border-slate-100 z-0"></div>
        </div>
    </div>

    {{-- Line Chart & Horizontal Bar Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div
            class="lg:col-span-6 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="text-base font-semibold text-slate-800">Tren Pemotongan Tahunan</h3>
            </div>
            <div class="w-full flex-1 min-h-75 sm:min-h-90">
                <div wire:ignore id="trenLineChart" class="h-full w-full"></div>
            </div>
        </div>

        <div
            class="lg:col-span-6 bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="text-base font-semibold text-slate-800">Distribusi Pemotongan Bulanan</h3>
            </div>
            <div class="w-full flex-1 min-h-75 sm:min-h-90">
                <div wire:ignore id="bulanBarChart" class="h-full w-full"></div>
            </div>
        </div>
    </div>

    {{-- Bar Chart --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="text-base font-semibold text-slate-800">Distribusi Pemotongan Kabupaten/Kota</h3>
        </div>
        <div class="w-full flex-1 min-h-75 sm:min-h-90">
            <div wire:ignore id="kabBarChart" class="h-full w-full"></div>
        </div>
    </div>

    {{-- Tabel Rincian Data --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="text-base font-semibold text-slate-800">Rincian Data Pemotongan Tercatat</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-600">
                <thead class="text-xs uppercase bg-slate-50 text-slate-700 border-b">
                    <tr>
                        <th class="p-3">Bulan</th>
                        <th class="p-3">Kabupaten/Kota</th>
                        <th class="p-3">Tempat Pemotongan (RPH/TPH)</th>
                        <th class="p-3">Jenis Ternak</th>
                        <th class="p-3 text-right">Jumlah (Ekor)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tableData as $row)
                    <tr class="hover:bg-slate-50">
                        <td class="p-3 font-medium text-slate-800">{{
                            \Carbon\Carbon::parse($row->bulan)->translatedFormat('F Y') }}</td>
                        <td class="p-3">{{ $row->tempatPemotongan->kabupaten->nama ?? '-' }}</td>
                        <td class="p-3 font-medium">{{ $row->tempatPemotongan->nama ?? '-' }}</td>
                        <td class="p-3 font-semibold">{{ $row->jenis_ternak }}</td>
                        <td class=" p-3 text-right font-bold text-slate-800">{{ number_format($row->jumlah_pemotongan,
                            0,
                            ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center italic text-slate-400">Tidak ada data tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $tableData->links() }}
        </div>
    </div>
</div>

@script
<script>
    // map
    let selectedKabId = @json($mapDataKab);
    let mapStats = @json($mapDataStats);
    let mapMarkers = @json($mapDataMarkers);

    let map = L.map('map').setView([-0.026330, 109.342504], 7)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let geojsonLayer = null;
    let rawGeoJsonData = null;
    let markerGroup = L.layerGroup().addTo(map);

    function getColor(d) {
        return d > 10000 ? '#065f46' :
            d > 5000 ? '#047857' :
            d > 1000 ? '#10b981' :
            d > 100 ? '#6ee7b7' :
            d > 0 ? '#a7f3d0' : '#f1f5f9';
    }

    let previousKabId = null;
    function renderGeoJson(dataGeoJson, currentKabId, stats) {
        if (geojsonLayer) {
            map.removeLayer(geojsonLayer);
        }

        geojsonLayer = L.geoJson(dataGeoJson, {
            style: function(feature) {
                let kabId = feature.properties.CC_2;
                let statData = stats[kabId] || {
                    total: 0,
                    jumlah_tempat: 0
                };
                let isSelected = (currentKabId === 'ALL' || currentKabId == kabId);

                return {
                    fillColor: getColor(statData.total),
                    weight: isSelected ? 2 : 1,
                    opacity: 1,
                    color: isSelected ? '#0f172a' : '#cbd5e1',
                    fillOpacity: isSelected ? 0.75 : 0.15
                };
            },
            onEachFeature: function(feature, layer) {
                let kabId = feature.properties.CC_2;
                let kabNama = feature.properties.NAME_2;
                let statData = stats[kabId] || {
                    total: 0,
                    jumlah_tempat: 0
                };

                layer.bindTooltip(`
                    <div class="p-0.5 space-y-1">
                        <div class="font-bold text-slate-800 border-b border-slate-200 pb-1 text-xs">${kabNama}</div>
                        <div class="text-[11px] text-slate-600 leading-tight">
                            Jumlah Pemotongan: <b class="text-emerald-600">${statData.total.toLocaleString('id-ID')} Ekor</b>
                        </div>
                        <div class="text-[11px] text-slate-600 leading-tight">
                            RPH/TPH: <b class="text-slate-800">${statData.jumlah_tempat.toLocaleString('id-ID')} Unit</b>
                        </div>
                    </div>
                `), {
                    direction: 'auto',
                    sticky: true
                };

                layer.on('click', function() {
                    $wire.set('kab', kabId);
                });
            }
        }).addTo(map);

        if (previousKabId !== currentKabId) {
            if (currentKabId !== 'ALL') {
                geojsonLayer.eachLayer(function(layer) {
                    if (layer.feature.properties.CC_2 == currentKabId) {
                        map.fitBounds(layer.getBounds(), {
                            padding: [30, 30],
                            maxZoom: 12
                        });
                        isFound = true;
                    }
                });
            } else {
                map.fitBounds(geojsonLayer.getBounds());
            }
            previousKabId = currentKabId;
        }
    }

    function renderMarkers(markers) {
        markerGroup.clearLayers();

        if (!markers || markers.length === 0) return;

        let markerBounds = [];

        markers.forEach(item => {
            let marker = L.marker([item.lat, item.lng])
                .bindPopup(`
                    <div class="p-1 min-w-[180px]">
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">${item.nama}</span>
                        <p class="text-xs text-slate-600">Jumlah Pemotongan: <b>${item.total.toLocaleString('id-ID')} Ekor</b></p>
                    </div>
                `, {
                    minWidth: 180,
                    maxWidth: 300
                });

            markerGroup.addLayer(marker);
            markerBounds.push([item.lat, item.lng]);
        });

        if (markerBounds.length > 0 && previousKabId !== currentKabId) {
            map.fitBounds(markerBounds, {
                padding: [50, 50],
                maxZoom: 12
            });
        }
    }

    fetch('/js/kalbar.json')
        .then(response => response.json())
        .then(data => {
            rawGeoJsonData = data;
            renderGeoJson(rawGeoJsonData, selectedKabId, mapStats);
            renderMarkers(mapMarkers);
        })
        .catch(error => console.error('Gagal memuat file GeoJSON:', error));

    let mapEl = document.getElementById('map');
    if (mapEl) {
        new ResizeObserver(() => {
            map.invalidateSize();
        }).observe(mapEl);
    }

    $wire.on('update-map-data', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload && rawGeoJsonData) {
            renderGeoJson(rawGeoJsonData, payload.selectedKabupatenId, payload.stats);
            renderMarkers(payload.markers);
        }
    });

    // line chart
    let trenCategories = @json($trenCategories);
    let trenDataJumlah = @json($trenJumlah);

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
            width: 3
        },
        colors: ['#10b981'],
        series: [{
            name: 'Jumlah Pemotongan',
            data: trenDataJumlah
        }],
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
                    name: 'Jumlah Pemotongan',
                    data: payload.jumlah
                }]
            });
        }
    });

    // horizontal bar chart
    let bulanCategories = @json($bulanCategories);
    let bulanDataJumlah = @json($bulanJumlah);

    let bulanOptions = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: true,
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
        colors: ['#0284c7'],
        series: [{
            name: 'Jumlah Pemotongan',
            data: bulanDataJumlah
        }],
        xaxis: {
            categories: bulanCategories,
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '12px'
                },
                formatter: (val) => new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(val)
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#64748b',
                    fontSize: '12px'
                }
            }
        },
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

    let bulanBarChart = new ApexCharts(document.querySelector("#bulanBarChart"), bulanOptions);
    bulanBarChart.render();

    $wire.on('update-bulan-bar-chart', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload) {
            bulanBarChart.updateOptions({
                xaxis: {
                    categories: payload.categories
                },
                series: [{
                    name: 'Jumlah Pemotongan',
                    data: payload.jumlah
                }]
            });
        }
    });

    // bar chart
    let kabCategories = @json($kabCategories);
    let kabDataJumlah = @json($kabJumlah);

    let kabOptions = {
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
        colors: ['#f43f5e'],
        series: [{
            name: 'Jumlah Pemotongan',
            data: kabDataJumlah
        }],
        xaxis: {
            categories: kabCategories,
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

    let kabBarChart = new ApexCharts(document.querySelector("#kabBarChart"), kabOptions);
    kabBarChart.render();

    $wire.on('update-kab-bar-chart', (event) => {
        let payload = Array.isArray(event) ? event[0] : event;

        if (payload) {
            kabBarChart.updateOptions({
                xaxis: {
                    categories: payload.categories
                },
                series: [{
                    name: 'Jumlah Pemotongan',
                    data: payload.jumlah
                }]
            });
        }
    });
</script>
@endscript