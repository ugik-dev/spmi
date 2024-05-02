    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <x-custom.statbox>
                <x-custom.alerts />
                <x-custom.budget-implementation.table-pdf :totalSum="$totalSum" :dipa="$dipa" :groupedBI="$groupedBI" />
            </x-custom.statbox>
        </div>
    </div>
