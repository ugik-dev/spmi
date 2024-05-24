<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/flatpickr/flatpickr.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/noUiSlider/nouislider.min.css') }}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/table/datatable/datatables.css') }}">
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
            td,
            th {
                border-radius: 0px !important;
            }

            th {
                color: white !important;
            }

            a.text-danger {
                transition: color 0.3s ease;
            }

            a.text-danger:hover {
                color: #dc3545;
            }

            .icon-trash {
                width: 30px;
                height: 30px;
                color: #dc3545;
            }

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

            .flatpickr-wrapper {
                width: 100%;
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
                <div class="table-responsive my-4 p-2">
                    <div class="d-flex flex-wrap justify-content-between py-2 my-2 me-1">
                        <div class="d-flex flex-wrap gap-1 my-2">
                            <button class="btn btn-primary shadow-sm" id="addBtn">Tambah Timeline
                            </button>
                        </div>
                    </div>
                    <table id="receipt-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Jenis </th>
                                <th scope="col">Metode Approval</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Dari </th>
                                <th scope="col">Sampai</th>
                                <th scope="col">User </th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timelines as $index => $receipt)
                                <tr>
                                    <td>{{ strtoupper(categoryTimeline($receipt->category)) }}</td>
                                    <td>{!! $receipt->metode !!}</td>
                                    <td>{{ $receipt->year }}</td>
                                    <td>{{ $receipt->start }}</td>
                                    <td>{{ $receipt->end }}</td>
                                    <td>{{ $receipt->user->name }}</td>
                                    <td class="text-center">
                                        {{-- <a class="btn-group btn btn-sm btn-primary temporary-edit"
                                            href="{{ route('payment-receipt.detail', $receipt) }}">
                                            <i data-feather="eye"></i>
                                        </a> --}}

                                        <button type="button" class="btn btn-sm btn-primary contentEdit"
                                            data-index="{{ $index }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-edit-2">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg>
                                        </button>
                                        <a href="{{ route('timeline.rekap', $receipt->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Rekapitulasi
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                            onclick="confirmDelete({{ $receipt->id }});">
                                            <i class="text-white" data-feather="trash-2"></i>
                                        </a>

                                        <!-- Hidden form for delete request -->
                                        <form id="delete-form-{{ $receipt->id }}"
                                            action="{{ route('timeline.destroy', $receipt->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-custom.statbox>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalTitle"
        aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentModalTitle">Form {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="contentForm" method="POST">
                        @csrf
                        <input id="dataId" name="id" hidden>
                        <div class="mb-4 row">
                            <label for="category" class="col-sm-2 col-form-label">Jenis</label>
                            <div class="col-sm-8">
                                <select name="category" class="form-select" id="category" required>
                                    <option selected disabled value="">...</option>
                                    <option value="pra-creat">Indikatif Dipa</option>
                                    <option value="creat">Pembuatan Dipa</option>
                                    <option value="revision">Revisi</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="metode" class="col-sm-2 col-form-label">Metode Approval</label>
                            <div class="col-sm-8">
                                <select name="metode" class="form-select" id="metode" required>
                                    <option selected disabled value="">...</option>
                                    <option value="ppk">PPK</option>
                                    <option value="kpa">KPA</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Periode</label>
                            <div class="col-sm-8 flatpickr">
                                <input name="year" id="year" required class="form-control active text-dark"
                                    type="text" placeholder="">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Dari</label>
                            <div class="col-sm-8 flatpickr">
                                <input id="start" name="start"
                                    class="form-control flatpickr flatpickr-input active text-dark"
                                    type="datetime-local" placeholder="Pilih tanggal.." required>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Sampai</label>
                            <div class="col-sm-8 flatpickr">
                                <input id="end" name="end"
                                    class="form-control flatpickr flatpickr-input active text-dark"
                                    type="datetime-local" placeholder="Pilih tanggal.." required>
                            </div>
                        </div>
                        <button id="contentStore" data-btnAction="store"
                            class="btn btn-primary text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                        <button id="contentUpdate" data-btnAction="update"
                            class="btn btn-primary text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Update</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-custom.payment-receipt.edit-modal />

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/custom.js') }}"></script>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script type="module" src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/pdfmake/vfs_fonts.js') }}"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('plugins-rtl/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('plugins-rtl/input-mask/input-mask.js') }}"></script> --}}
        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })

            document.addEventListener('DOMContentLoaded', function() {
                const dataContent = @json($timelines);
                const theadTh = document.querySelectorAll('thead tr th');
                theadTh.forEach(th => th.classList.add('bg-primary'));
                const editModalEl = document.getElementById('editModal');
                const addBtn = $('#addBtn');
                // const contentModal = $('#contentModal');
                let receiptEditData;
                var contentModal = {
                    'self': $('#contentModal'),
                    'info': $('#contentModal').find('.info'),
                    'form': $('#contentModal').find('#contentForm'),
                    'addBtn': $('#contentModal').find('#contentStore'),
                    'updateBtn': $('#contentModal').find('#contentUpdate'),
                    'dataId': $('#contentModal').find('#dataId'),
                    'metode': $('#contentModal').find('#metode'),
                    'category': $('#contentModal').find('#category'),
                    'start': $('#contentModal').find('#start'),
                    'end': $('#contentModal').find('#end'),
                    'year': $('#contentModal').find('#year'),
                }
                $('#receipt-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            className: 'btn btn-danger', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'PDF_Export_' + n;
                            },
                            customize: function(doc) {
                                doc.styles.tableHeader.alignment = 'left'; // Contoh penyesuaian
                                // Tambahkan kustomisasi pdfmake Anda di sini
                                doc.content[1].table.widths = ['auto', '*', '*'];
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-success', // Warna biru
                            exportOptions: {
                                columns: [0, 1, 2] // Indeks kolom yang ingin Anda ekspor (dimulai dari 0)
                            },
                            filename: function() {
                                var d = new Date();
                                var n = d.toISOString();
                                return 'Excel_Export_' + n;
                            },
                        }
                    ],
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Cari Kuitansi...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });


                addBtn.on('click', function(event) {
                    console.log('openModal')
                    contentModal.form[0].reset();
                    contentModal.self.modal('show');
                    contentModal.addBtn.show();
                    contentModal.updateBtn.hide();
                })

                $('.contentEdit').on('click', (ev) => {
                    contentModal.form[0].reset();
                    contentModal.addBtn.hide();
                    contentModal.updateBtn.show();

                    var index = $(ev.currentTarget).data('index');
                    currentData = dataContent[index];
                    contentModal.year.val(currentData['year']);
                    contentModal.metode.val(currentData['metode']);
                    contentModal.category.val(currentData['category']);
                    contentModal.start.val(currentData['start']);
                    contentModal.end.val(currentData['end']);
                    contentModal.dataId.val(currentData['id']);
                    contentModal.self.modal('show');
                    console.log(dataContent[index])

                })
                contentModal.form.on('submit', function(event, action) {
                    event.preventDefault()
                    var url = contentModal.addBtn.is(':visible') ? '{{ route('timeline.store') }}' :
                        '{{ route('timeline.store_update') }}';

                    Swal.fire({
                        title: "Apakah anda Yakin?",
                        text: "Data Disimpan!",
                        icon: "warning",
                        allowOutsideClick: false,
                        showCancelButton: true,
                        buttons: {
                            cancel: 'Batal !!',
                            catch: {
                                text: "Ya, Saya Simpan !!",
                                value: true,
                            },
                        },
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            return;
                        }
                        swalLoading();
                        $.ajax({
                            url: url,
                            'type': 'POST',
                            data: contentModal.form.serialize(),
                            success: function(data) {

                                Swal.fire({
                                    title: "Berhasil",
                                    text: "Data Disimpan!",
                                    icon: "success",
                                    allowOutsideClick: true,
                                    showConfirmButton: true,
                                }).then((result) => {
                                    location.reload();
                                })
                                // var user = json['data']
                                // dataUser[user['id']] = user;
                                // Swal.fire("Simpan Berhasil", "", "success");
                                // renderUser(dataUser);
                                // UserModal.self.modal('hide');
                            },
                            error: function(e) {
                                console.log(e.responseJSON.message);
                                Swal.fire("Simpan Gagal", e.responseJSON.message ??
                                    'Terjadi Kesalahan', "error");
                            }
                        });
                    });
                })
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
