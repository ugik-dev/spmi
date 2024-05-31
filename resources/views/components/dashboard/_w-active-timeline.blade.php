{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-six/>.
* 
*/

--}}


<div class="widget widget-card-four mb-2">
    <div class="widget-content">
        <div class="w-header">
            <div class="w-info">
                <h5 class="">{{ $title }}</h5>
            </div>
        </div>
    </div>
    <div class="w-content">
        <div class="w-chart-section">
            <div class="w-detail">
                @php
                    if ($timelinesActive->category ?? false) {
                        if ($timelinesActive->category == 'creat') {
                            $ket = 'Pembuatan Dipa Definitif';
                        } elseif ($timelinesActive->category == 'pra-creat') {
                            $ket = 'Pembuatan Dipa Indikatif';
                        } elseif ($timelinesActive->category == 'revison') {
                            $ket = 'Revisi Dipa';
                        } else {
                            $ket = ' - ';
                        }
                    }
                @endphp
                @if ($timelinesActive)
                    <p class="w-title">{{ $ket . ' Tahun ' . $timelinesActive->year }}</p>
                    <p class="w-stats">{{ $timelinesActive->end }}</p>
                @endif
            </div>

        </div>
    </div>
</div>
