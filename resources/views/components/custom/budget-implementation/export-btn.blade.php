<div class="btn-group" role="group">
    <button id="btndefault" type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">Export <svg xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg></button>
    <div class="dropdown-menu" aria-labelledby="btndefault">
        {{-- <a href="{{ route('dipa.fpdf', $dipaId) }}" class="dropdown-item" role="button">
            PDF
        </a> --}}
        <a href="{{ route('dipa.cetak', $dipaId) }}" target="_blank" class="dropdown-item" role="button">
            Excel Dipa
        </a>
        {{-- <a href="{{ route('dipa.cetak-mapping', $dipaId) }}" target="_blank" class="dropdown-item" role="button">
            Excel Full Mapping
        </a> --}}
    </div>
</div>
