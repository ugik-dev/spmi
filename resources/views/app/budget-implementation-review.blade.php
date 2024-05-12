<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
            #add-account_code_btn,
            #add-expenditure_detail_btn {
                opacity: 0;
                visibility: hidden;

                &.show {
                    opacity: 1;
                    visibility: visible;
                }
            }

            th,
            tr {
                td:first-child {
                    font-weight: bold !important;
                }

                &.selected td {
                    background-color: #2196f3 !important;
                    color: white;
                }

                &.activity-row td {
                    background-color: #fcf5e9;
                    font-weight: bold !important;
                    font-style: italic !important;
                }

                &.account-row td {
                    font-style: italic !important;
                }

                td:first-child,
                td:nth-child(3),
                td:nth-child(4) {
                    text-align: center;
                }
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-lg-12 layout-spacing">
            <x-custom.statbox>
                <x-custom.alerts />
                <x-custom.budget-implementation.table-review :totalSum="$totalSum" :unitBudget="$unitBudget" :dipa="$dipa"
                    :btnExport="$btnExport" :groupedBI="$groupedBI" />
            </x-custom.statbox>
        </div>
    </div>
    <x-custom.budget-implementation.edit-modal />
    <x-custom.budget-implementation.catatan-modal />
    <x-custom.budget-implementation.rpd-modal :months='$months' />

    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            const accountCodes = @json($accountCodes);
            const indikatorPerkin = @json($indikatorPerkin);
            const expenditureUnits = @json($expenditureUnits);
            document.addEventListener('DOMContentLoaded', function() {
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                const tdMoney = document.querySelectorAll(
                    'tr.expenditure-row td:nth-child(5),tr.expenditure-row td:nth-child(6)')
                const tableBody = document.querySelector('tbody.dipa-table');
                tableBody.addEventListener('click', handleRowClick);
                @if (empty($dipa) || $dipa->status == 'draft' || $dipa->status == 'reject')
                    const formCreate = document.getElementById('form-create');
                    const formEdit = document.getElementById('form-edit');
                    const table = document.getElementById('budget_implementation-table');
                    const createModalEl = document.getElementById('createModal');
                    const saveDipaBtn = document.getElementById('save-dipa');
                    const sendDipaBtn = document.getElementById('send-dipa');
                    const editDipaBtn = document.getElementById('edit-dipa');
                    const deleteDipaBtn = document.getElementById('delete-dipa');
                    const editModalEl = document.getElementById('editModal');
                    const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl)
                    editDipaBtn.addEventListener('click', event => {
                        const trSelected = document.querySelector('tr.selected');

                        if (!trSelected) {
                            Swal.fire({
                                title: 'Pilih dipa!',
                                text: 'Silahkan pilih dipa untuk di edit terlebih dahulu.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            editModal.show();
                        }
                    });
                    deleteDipaBtn.addEventListener('click', event => {
                        const trSelected = document.querySelector('tr.selected');
                        if (!trSelected) {
                            Swal.fire({
                                title: 'Pilih dipa!',
                                text: 'Silahkan pilih dipa untuk di edit terlebih dahulu.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            if (trSelected.classList.contains('activity-row')) return confirmDeleteDipa(
                                'activity',
                                trSelected.dataset.bi, trSelected.children[1].textContent, trSelected
                                .dataset.crow);
                            if (trSelected.classList.contains('account-row')) return confirmDeleteDipa(
                                'account',
                                trSelected.dataset.bi, trSelected.children[1].textContent, trSelected
                                .dataset.crow);
                            if (trSelected.classList.contains('expenditure-row')) return confirmDeleteDipa(
                                'detail',
                                trSelected.dataset.expenditure, trSelected.children[2].textContent,
                                trSelected
                                .dataset.crow);
                            return;
                        }
                    });

                    editModalEl.addEventListener('show.bs.modal', function(event) {
                        const trSelected = document.querySelector('tr.selected');
                        const editInputContainer = document.getElementById('edit-input_container');
                        const editInputContainer2 = document.getElementById('edit-input_sigle_container');

                        if (trSelected.classList.contains('activity-row')) {
                            editModalTitle.textContent = "Input Sub Komponen";
                            editInputContainer.innerHTML =
                                `<input type="hidden" name="id" value="${trSelected.dataset.bi}"><input type="hidden" name="type" value="activity"><input type="text" name="code" value="${trSelected.children[1].textContent}" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Keg"> <input type="text" value="${trSelected.children[2].textContent}" required name="name" class="form-control" placeholder="Uraian">`

                            let options = indikatorPerkin.map(code =>

                                `<option ${trSelected.children[0].textContent == code.id ? 'selected':''} value="${code.id}" data-account-name="${code.name}">${code.name}</option>`
                            ).join('');
                            editInputContainer2.innerHTML =
                                `<select name="performance_indicator_id" style="width: 100% !important" id="performance_indicator_id" required class="form-control" style=""><option value="">Pilih Indikator PERKIN</option>${options}</select>`;


                        } else if (trSelected.classList.contains('account-row')) {
                            editModalTitle.textContent = "Input Kode Akun";
                            editInputContainer2.innerHTML = '';
                            let options = accountCodes.map(code =>
                                `<option value="${code.code}" data-account-name="${code.name}">${code.code}</option>`
                            ).join('');

                            editInputContainer.innerHTML =
                                `
                                <input type="hidden" name="id" value="${trSelected.dataset.bi}">
                                <input type="hidden" name="type" value="account">
                                <select name="code" id="account-code-select" required class="form-control" style="max-width: 200px !important;"><option value="">Pilih Kode Akun</option>${options}</select><input type="text" id="account-name-input" disabled required name="name" class="form-control" placeholder="Uraian">`;

                            // Set the value of the select element
                            const accountCodeSelect = document.getElementById('account-code-select');
                            accountCodeSelect.value = trSelected.children[1].textContent;

                            // Add event listener for change event
                            accountCodeSelect.addEventListener('change', function() {
                                const selectedOption = this.options[this.selectedIndex];
                                const accountName = selectedOption.getAttribute('data-account-name');
                                document.getElementById('account-name-input').value = accountName || '';
                            });

                            // Manually trigger the change event
                            accountCodeSelect.dispatchEvent(new Event('change'));
                        } else {
                            editInputContainer2.innerHTML = '';

                            editModalTitle.textContent = "Input Detail";

                            let options = expenditureUnits.map(unit =>
                                `<option value="${unit.code}">${unit.code}</option>`
                            ).join('');

                            editInputContainer.innerHTML =
                                `<input type="hidden" name="id" value="${trSelected.dataset.expenditure}"><input type="hidden" name="type" value="detail"><input type="text" required name="name" value="${trSelected.children[2].textContent}" class="form-control" placeholder="Uraian Detail">
                            <input type="text" required name="volume" value="${trSelected.children[3].textContent}" class="form-control" style="max-width: 100px !important;" placeholder="Volume">
                            <select name="unit" required class="form-control" style="max-width: 150px !important;">${options}</select>
                            <input type="text" name="unit_price" value="${trSelected.children[5].textContent}" required class="form-control" placeholder="Harga Satuan">
                            <input type="text" readonly name="total" value="${trSelected.children[6].textContent}" required class="form-control" placeholder="Total">`;

                            // Set the correct unit in the dropdown
                            const unitSelect = editInputContainer.querySelector('select[name="unit"]');
                            unitSelect.value = trSelected.children[4].textContent;

                            // Now add the event listeners
                            const volumeInput = editInputContainer.querySelector(
                                'input[name="volume"]');
                            const priceInput = editInputContainer.querySelector('input[name="unit_price"]');
                            const totalInput = editInputContainer.querySelector('input[name="total"]');

                            volumeInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                priceInput, totalInput));
                            priceInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                priceInput, totalInput));
                            volumeInput.addEventListener('keypress', window.enforceNumericInput);
                        }
                    });

                    createModalEl.addEventListener('show.bs.modal', event => {
                        const btnShowModalId = event.relatedTarget.id;
                        const createModalTitle = document.getElementById('createModalTitle');

                        const modalTitles = {
                            'add-activity_btn': 'Input Sub Komponen',
                            'add-account_code_btn': 'Input Kode Akun',
                            default: 'Input Detail'
                        };

                        createModalTitle.textContent = modalTitles[event.relatedTarget.id] || modalTitles
                            .default;

                        const createInputContainer = document.getElementById('create-input_container');
                        const createInputContainer2 = document.getElementById('create-input_sigle_container');

                        if (btnShowModalId === 'add-activity_btn') {
                            createInputContainer.innerHTML =
                                `<input type="text" name="activity_code" required class="form-control" style="max-width: 160px !important;"placeholder="KD.Keg"> <input type="text" required name="activity_name" class="form-control" placeholder="Uraian">`;
                            let options = indikatorPerkin.map(code =>
                                `<option value="${code.id}" data-account-name="${code.name}">${code.name}</option>`
                            ).join('');
                            createInputContainer2.innerHTML =
                                `<select name="performance_indicator_id" style="width: 100% !important" id="performance_indicator_id" required class="form-control" style=""><option value="">Pilih Indikator PERKIN</option>${options}</select>`;
                            $('#performance_indicator_id').select2({
                                dropdownParent: $('#createModal'),
                                placeholder: 'Pilih IKU',
                                theme: 'bootstrap-5'
                            });
                        }
                        if (btnShowModalId === 'add-account_code_btn') {
                            createInputContainer2.innerHTML = '';
                            let options = accountCodes.map(code =>
                                `<option value="${code.code}" data-account-name="${code.name}">${code.code}</option>`
                            ).join('');
                            createInputContainer.innerHTML =
                                `<select name="account_code" id="account-code-select" required class="form-control" style="max-width: 200px !important;"><option value="">Pilih Kode Akun</option>${options}</select><input type="text" id="account-name-input" disabled required name="account_name" class="form-control" placeholder="Uraian">`;

                            // Add event listener for change event
                            document.getElementById('account-code-select').addEventListener('change',
                                function() {
                                    const selectedOption = this.options[this.selectedIndex];
                                    const accountName = selectedOption.getAttribute('data-account-name');
                                    document.getElementById('account-name-input').value = accountName || '';
                                });
                        }
                        if (btnShowModalId === 'add-expenditure_detail_btn') {
                            createInputContainer2.innerHTML = '';

                            let options = expenditureUnits.map(unit =>
                                `<option value="${unit.code}">${unit.code}</option>`
                            ).join('');
                            createInputContainer.innerHTML =
                                `<input type="text" required name="expenditure_description" class="form-control" placeholder="Uraian Detail"><input type="text" required name="expenditure_volume" class="form-control"style="max-width: 100px !important;" placeholder="Volume"><select name="unit" required class="form-control" style="max-width: 150px !important;"><option value="">Pilih Satuan</option>${options}</select><input type="text" disabled name="unit_price" required class="form-control" placeholder="Harga Satuan"><input disabled type="text" name="total" required class="form-control" placeholder="total">`;

                            // Now add the event listeners
                            const volumeInput = createInputContainer.querySelector(
                                'input[name="expenditure_volume"]');
                            const priceInput = createInputContainer.querySelector('input[name="unit_price"]');
                            const totalInput = createInputContainer.querySelector('input[name="total"]');
                            if (volumeInput && priceInput && totalInput) {
                                volumeInput.addEventListener('input', function() {
                                    const isVolumeFilled = volumeInput.value.trim() !== '';
                                    priceInput.disabled = !isVolumeFilled;
                                    totalInput.disabled = !isVolumeFilled;

                                    if (!isVolumeFilled) {
                                        // Clear values when volume is not filled
                                        priceInput.value = '';
                                        totalInput.value = '';
                                    }
                                });
                            }
                            volumeInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                priceInput, totalInput));
                            priceInput.addEventListener('input', () => calculateAndUpdateTotal(volumeInput,
                                priceInput, totalInput));
                            volumeInput.addEventListener('keypress', window.enforceNumericInput);
                        }

                    })

                    formCreate.addEventListener('submit', handleFormSubmit);
                    formEdit.addEventListener('submit', handleFormEditSubmit);
                    saveDipaBtn.addEventListener('click', handleSaveDipaClick);
                    sendDipaBtn.addEventListener('click', handleSendDipaClick);
                @endif

            });

            async function fetchRPD(activity) {
                try {
                    const response = await axios.get(
                        `/api/withdrawal-plans-detail/${activity}`);
                    resetModalAmounts();
                    populateModalWithData(response.data, activity);
                } catch (error) {
                    showErrorAlert('Kesalahan', 'Gagal memuat data penarikan dana.');
                }
            }

            function addCatatan(activity) {
                fetchCatatan(activity)
            }

            async function fetchCatatan(activity) {
                try {
                    showLoading()
                    const response = await axios.get(
                        `/api/activity-note-check/${activity}`);

                    showCatatanModal(response.data, activity);
                } catch (error) {
                    let errorMessage = 'Terjadi kesalahan.';

                    // Cek apakah error memiliki respons dari server
                    if (error.response && error.response.data && error.response.data.message) {
                        errorMessage = error.response.data.message;
                    }

                    showErrorAlert('Kesalahan', errorMessage);
                }
            }

            function showCatatanModal(response, activity) {
                swal.close();
                console.log(response)
                document.getElementById('catatan_activity').value = activity;
                document.getElementById('catatan_id').value = response.id ?? '';
                document.getElementById('catatan_description').value = response.description ?? '';
                $('#catatanModal').modal('show');
            }
            $('#form-catatan').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);

                axios.post(
                        "{{ route('dipa-action.add_note') }}",
                        formData
                    )
                    .then(response => {
                        // Success feedback
                        res_id = response.data.id

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil untuk disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {

                            location.reload()

                        });
                    })
                    .catch(error => {
                        // Error handling
                        let errorMessage = 'Terjadi kesalahan. Silahkan coba sesaat lagi.';
                        if (error.response && error.response.data && error.response.data.message) {
                            errorMessage = error.response.data.message;
                        }

                        Swal.fire({
                            title: 'Gangguan!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });

                event.target.reset();
                $('#catatanModal').modal('hide');
            });

            function resetModalAmounts() {
                for (let i = 1; i <= 12; i++) {
                    const monthElement = document.getElementById(`amount-${i}`);
                    if (monthElement) {
                        monthElement.value = '-';
                    }
                }
            }

            function showLoading() {

                Swal.fire({
                    title: 'Loading',
                    // text: 'Mohon menunggu data untuk disimpan terlebih dahulu.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            function showErrorAlert(title, message) {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: 'error'
                });
            }

            function populateModalWithData(response, activity) {
                let totalAccumulated = 0;
                response.data.forEach(plan => {
                    const monthElement = document.getElementById(`amount-${plan.month}`);
                    if (monthElement) {
                        const amount = parseFloat(plan.amount_withdrawn) || 0;
                        monthElement.value = amount === 0 ? "-" : window.formatAsIDRCurrency(amount);
                        totalAccumulated += amount;
                    }
                });
                let residual = response.totalActivity - totalAccumulated;
                document.getElementById('withdrawalPlanModalLabel').innerText =
                    `${response.activity.code} - ${response.activity.name}`;
                document.getElementById('totalAccumulated').textContent = window.formatAsIDRCurrency(totalAccumulated);
                // document.getElementById('accumulatedTotalSum').innerText = window.formatAsIDRCurrency(activity.accumulatedSum);
                document.getElementById('residual').innerText = window.formatAsIDRCurrency(residual);
                document.getElementById('currentActivityId').value = activity;
                $('#withdrawalPlanModal').modal('show');
            }

            function handleViewFile(url, mimeType) {
                if (mimeType === 'application/pdf' || mimeType === 'image/jpeg') {
                    // Membuka file dalam tab baru jika PDF atau gambar
                    window.open(url, '_blank');
                } else if (mimeType === 'application/zip') {
                    // Mengunduh file jika zip
                    window.location.href = url;
                }
            }

            function handleSaveDipaClick() {
                const dipaData = groupRows();
                // const endpoint = window.Laravel.routes.budgetImplementationStore;
                // console.log(endpoint);

                // Show a loading indicator
                Swal.fire({
                    title: 'Menyimpan data...',
                    text: 'Mohon menunggu data untuk disimpan terlebih dahulu.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post(
                        "{{ !empty($dipa->id) ? route('dipa.update', $dipa->id) : route('budget_implementation.store') }}", {
                            dipa: dipaData,
                            @if (!empty($copy_of))
                                copy_of: '{{ $copy_of }}'
                            @endif
                        })
                    .then(response => {
                        // Success feedback
                        // console.log(fetchdata.data)
                        res_id = response.data.id

                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil untuk disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            @if (!empty($dipa->id))
                                window.location.reload();
                            @else
                                // console.log(response.data)
                                window.location.href = '{{ url('admin/penganggaran/dipa') }}/' + res_id;
                            @endif

                        });
                    })
                    .catch(error => {
                        // Error handling
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }

            function handleSendDipaClick() {
                Swal.fire({
                    title: 'Mengajukan data...',
                    text: 'Mohon menunggu..',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post("{{ !empty($dipa->id) ? route('dipa.ajukan', $dipa->id) : '' }}", {})
                    .then(response => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil diajukan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();

                        });
                    })
                    .catch(error => {
                        // Error handling

                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }

            function groupRows() {
                let rows = document.querySelectorAll('tr');
                let groupedRows = [];
                let currentActivity = null;
                let currentAccount = null;

                rows.forEach(row => {
                    if (row.classList.contains('activity-row')) {
                        let activityData = {
                            id: row.dataset.activity,
                            indicator_act: row.dataset.indicator_act,
                            performance_indicator_id: row.children[0].textContent,
                            code: row.children[1].textContent,
                            name: row.children[2].textContent
                        };
                        currentActivity = {
                            bi: row.dataset.bi,
                            activity: activityData,
                            accounts: []
                        };
                        groupedRows.push(currentActivity);
                    } else if (row.classList.contains('account-row')) {
                        let accountData = {
                            id: row.dataset.accountCode,
                            code: row.children[1].textContent,
                            name: row.children[2].textContent,
                            bi: row.dataset.bi,
                        };
                        currentAccount = {
                            account: accountData,
                            expenditures: []
                        };
                        if (currentActivity) {
                            currentActivity.accounts.push(currentAccount);
                        }
                    } else if (row.classList.contains('expenditure-row')) {
                        let unit_price = row.children[5].textContent.replace(/Rp|\./g, '').trim();
                        let total = row.children[6].textContent.replace(/Rp|\./g, '').trim();

                        let expenditureData = {
                            id: row.dataset.expenditure,
                            description: row.children[2].textContent,
                            volume: row.children[3].textContent,
                            unit: row.children[4].textContent,
                            unit_price: unit_price,
                            total: total
                        };
                        if (currentAccount) {
                            currentAccount.expenditures.push(expenditureData);
                        }
                    }
                });

                return groupedRows;
            }

            function confirmDeleteDipa(rowType, id, name, crow) {
                console.log('row', rowType, 'id', id, 'name', name, 'crow', crow)


                let rowTypeName = rowType === 'detail' ? 'detail' : (rowType === 'activiy' ? "Kode Keg" : "Kode Akun");
                Swal.fire({
                    title: `Anda yakin ingin hapus \n(${rowTypeName} : ${name})?`,
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (id == undefined) {
                        console.log('langsung delete')
                        const selectedElements = document.querySelectorAll('.crow-' + crow);
                        // Menghapus setiap elemen yang memiliki kelas "selected"
                        selectedElements.forEach(element => {
                            element.remove();
                        });
                        return;
                    }

                    if (result.isConfirmed) {
                        axios.delete(`/admin/penganggaran/hapus-dipa/${rowType}/${id}`)
                            .then(res => {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success'
                                }).then(() => {
                                    const selectedElements = document.querySelectorAll('.crow-' +
                                        crow);
                                    // Menghapus setiap elemen yang memiliki kelas "selected"
                                    selectedElements.forEach(element => {
                                        element.remove();
                                    });
                                });
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: 'Gangguan!',
                                    text: 'Gagal menghapus data.',
                                    icon: 'error'
                                });
                            });
                    }
                });
            }


            function calculateAndUpdateTotal(volumeInput, priceInput, totalInput) {
                const volume = parseFloat(volumeInput.value.replace(/[^0-9,.-]/g, '').replace(',', '.'));
                let unitPrice = parseFloat(priceInput.value.replace(/Rp\s?|,00/g, '').replace(/\./g, '').replace(
                    /[^\d]/g,
                    ''));

                if (!isNaN(volume) && !isNaN(unitPrice)) {
                    const total = volume * unitPrice;
                    totalInput.value = window.formatAsIDRCurrency(total);
                    priceInput.value = window.formatAsIDRCurrency(unitPrice);
                } else {
                    totalInput.value = '';
                }
            }

            function handleRowClick(e) {
                console.log('click')
                if (e.target.closest('tr')) {
                    clearSelectedRows();
                    const clickedRow = e.target.closest('tr');
                    clickedRow.classList.add('selected');
                    @if (empty($dipa) || $dipa->status == 'draft' || $dipa->status == 'reject')
                        toggleButtonsBasedOnRow(clickedRow);
                    @endif
                    // Mark the clicked row as the parent for the next entry
                    if (clickedRow.classList.contains('activity-row')) {
                        clickedRow.classList.add('activity-parent');
                        clickedRow.classList.remove('account-parent');
                    } else if (clickedRow.classList.contains('account-row')) {
                        clickedRow.classList.add('account-parent');
                    } else {

                    }
                }
            }

            function clearSelectedRows() {
                document.querySelectorAll('tr.selected').forEach(row => row.classList.remove('selected'));
            }

            function toggleButtonsBasedOnRow(row) {
                const isActivityRow = row.classList.contains('activity-row');
                const isAccountRow = row.classList.contains('account-row');
                const isExpenditureRow = row.classList.contains('expenditure-row');
                toggleButtonVisibility('add-expenditure_detail_btn', !isActivityRow);
                toggleButtonVisibility('add-account_code_btn', isActivityRow || isAccountRow || isExpenditureRow);
                if (!isExpenditureRow) {
                    row.classList.add(isActivityRow ? 'activity-parent' : (isAccountRow ? 'account-parent' : ''));
                }
            }

            function toggleButtonVisibility(buttonId, show) {
                const button = document.getElementById(buttonId);
                button.classList.toggle('show', show);
            }

            function determineRowType(formData) {
                // Check if it's an Activity
                if (formData.activity_code || formData.activity_name) {
                    return 'activity';
                }
                // Check if it's an Account
                else if (formData.account_code || formData.account_name) {
                    return 'account';
                }
                // Check if it's an Expenditure
                else if (formData.expenditure_description || formData.expenditure_volume) {
                    return 'expenditure';
                }

                return null; // or some default type if necessary
            }



            function handleFormEditSubmit(event) {
                event.preventDefault();
                const formElements = Array.from(event.target.elements).filter(element => element.name);

                // Convert form elements to an object
                const formData = formElements.reduce((obj, element) => {
                    obj[element.name] = element.value;
                    return obj;
                }, {});

                // Check the type of form data
                const isActivity = formData.activity_code || formData.activity_name;
                const isAccount = formData.account_code || formData.account_name;
                const isExpenditure = formData.unit || formData.unit_price;
                const trType = formData.type;

                console.log();
                console.log('f', formData, 'id', formData.id, 'type', trType);

                const trSelectedEdit = document.querySelector('tr.selected');
                if (formData.type == "detail") {
                    trSelectedEdit.children[2].textContent = formData.name
                    trSelectedEdit.children[3].textContent = formData.volume
                    trSelectedEdit.children[4].textContent = formData.unit
                    trSelectedEdit.children[5].textContent = formData.unit_price
                    trSelectedEdit.children[6].textContent = formData.total
                } else if (formData.type == "account") {
                    var result = accountCodes.filter(obj => {
                        return obj.code === formData.code
                    })
                    console.log(result[0]);
                    trSelectedEdit.children[1].textContent = formData.code
                    trSelectedEdit.children[2].textContent = result[0].name
                } else if (formData.type == "activity") {
                    trSelectedEdit.children[0].textContent = formData.performance_indicator_id
                    trSelectedEdit.children[1].textContent = formData.code
                    trSelectedEdit.children[2].textContent = formData.name
                } else {
                    return;
                }
                if (formData.id === 'undefined') {
                    //
                } else {
                    console.log('ada id')
                }
                // createAndAppendRowEdit(formData, formData.type);
                event.target.reset();
                // Hide the modal after form submission
                $('#editModal').modal('hide');
            }


            function handleFormSubmit(event) {
                event.preventDefault();
                const formElements = Array.from(event.target.elements).filter(element => element.name);

                // Convert form elements to an object
                const formData = formElements.reduce((obj, element) => {
                    obj[element.name] = element.value;
                    return obj;
                }, {});

                // Check the type of form data
                const isActivity = formData.activity_code || formData.activity_name;
                const isAccount = formData.account_code || formData.account_name;
                const isExpenditure = formData.expenditure_description || formData.expenditure_volume;
                const trType = determineRowType(formData);

                createAndAppendRow(formData, trType);
                event.target.reset();
                // Hide the modal after form submission
                $('#createModal').modal('hide');
            }

            function createAndAppendRow(data, type) {
                console.log(data);
                if (type === null) {
                    alert("Terdapat kesalahan pemrosesan...");
                    return;
                }
                const newRow = document.createElement('tr');
                const tableBody = document.querySelector('tbody.dipa-table');

                if (type === 'activity') {
                    newRow.innerHTML =
                        `<td hidden >${data.performance_indicator_id || ""}</td><td class="text-center">${data.activity_code || ""}</td><td>${data.activity_name || data.account_name || data.expenditure_description || ""}</td><td>${data.expenditure_volume || ""}</td><td>${data.unit || ""}</td><td>${data.unit_price || ""}</td><td class="${data.unit_price ? 'count_detail': ''}">${data.total || ""}</td>`;
                    newRow.classList.add(`${type}-row`);
                    tableBody.appendChild(newRow);
                } else {
                    newRow.innerHTML =
                        `<td hidden ></td><td class="text-center">${data.activity_code || data.account_code || ""}</td><td>${data.activity_name || data.account_name || data.expenditure_description || ""}</td><td>${data.expenditure_volume || ""}</td><td>${data.unit || ""}</td><td>${data.unit_price || ""}</td><td class="${data.unit_price ? 'count_detail': ''}">${data.total || ""}</td>`;
                    newRow.classList.add(`${type}-row`);
                    insertRowBasedOnType(newRow, type);
                }
            }

            function insertRowBasedOnType(newRow, type) {
                const tableBody = document.querySelector('tbody.dipa-table');
                const selectedRow = document.querySelector('tr.selected');
                if (!selectedRow) {
                    return;
                }

                let referenceRow = selectedRow;
                // Logic for inserting an activity row.
                if (type === 'activity') {
                    referenceRow = tableBody.lastElementChild;
                    while (referenceRow && !referenceRow.classList.contains('activity-row')) {
                        referenceRow = referenceRow.previousElementSibling;
                    }
                }
                // Logic for inserting an account row.
                else if (type === 'account') {
                    while (referenceRow.nextElementSibling &&
                        (referenceRow.nextElementSibling.classList.contains('account-row') ||
                            referenceRow.nextElementSibling.classList.contains('expenditure-row'))) {
                        referenceRow = referenceRow.nextElementSibling;
                    }
                }
                // Logic for inserting an expenditure row.
                else if (type === 'expenditure') {
                    while (referenceRow.nextElementSibling && referenceRow.nextElementSibling.classList.contains(
                            'expenditure-row')) {
                        referenceRow = referenceRow.nextElementSibling;
                    }
                }

                // Perform the insertion after the determined reference row.
                if (referenceRow === tableBody.lastElementChild) {
                    tableBody.appendChild(newRow); // Append at the end if referenceRow is the last child.
                } else {
                    referenceRow.insertAdjacentElement('afterend', newRow); // Insert after the reference row.
                }
            }
        </script>
        {{-- @endif --}}
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
