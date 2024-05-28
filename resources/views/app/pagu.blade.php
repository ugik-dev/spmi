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
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area" style="min-height:50vh;">
                    <div class="p-3 container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close text-white" data-bs-dismiss="alert"
                                    aria-label="Close"><i data-feather="x-circle"></i></button>
                            </div>
                        @endif
                    </div>

                    <div class="text-center d-flex justify-content-between align-items-center px-4">
                        <button class="btn btn-primary shadow-sm" id="addBtn">Tambah Tahun
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="receipt-table" class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Pagu Lembaga </th>
                                    <th scope="col">Pagu Unit </th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pagus as $index => $receipt)
                                    <tr>
                                        <td>{{ $receipt->year }}</td>
                                        <td>Rp {{ number_format($receipt->nominal) }}</td>
                                        <td><a href="{{ route('unit_budget.index', $receipt->year) }}"
                                                class="btn btn-info btn-sm" role="button">
                                                Lihat
                                            </a></td>
                                        <td class="text-center">
                                            {{-- <a class="btn-group btn btn-sm btn-primary temporary-edit"
                                                href="{{ route('payment-receipt.detail', $receipt) }}">
                                                <i data-feather="eye"></i>
                                            </a> --}}

                                            <button type="button" class="btn btn-sm btn-primary contentEdit"
                                                data-index="{{ $index }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit-2">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                    </path>
                                                </svg>
                                            </button>
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
                </div>
            </div>
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
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Tahun</label>
                            <div class="col-sm-8 flatpickr">
                                <input name="year" id="year" required class="form-control active text-dark"
                                    type="text" placeholder="">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputActivityDate" class="col-sm-2 col-form-label">Pagu</label>
                            <div class="col-sm-8 flatpickr">
                                <input name="nominal" id="nominal" required
                                    class="mask-nominal form-control active text-dark" type="text" placeholder="">
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
                const dataContent = @json($pagus);
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
                    'nominal': $('#contentModal').find('#nominal'),
                    'year': $('#contentModal').find('#year'),
                }
                $('#receipt-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            text: 'PDF',
                            className: 'buttons-pdf buttons-html5 btn btn-danger',
                            action: function(e, dt, node, config) {
                                window.location.href = "{{ route('download.pagu.pdf') }}";
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

                $('.mask-nominal').inputmask({
                    alias: 'numeric',
                    groupSeparator: '.',
                    radixPoint: ',',
                    digits: 2,
                    autoGroup: true,
                    prefix: 'Rp ', // Space after Rp
                    rightAlign: false,
                    removeMaskOnSubmit: true,
                    unmaskAsNumber: true
                });
                addBtn.on('click', function(event) {
                    console.log('openModal')
                    contentModal.form[0].reset();
                    contentModal.self.modal('show');
                    contentModal.addBtn.show();
                    contentModal.updateBtn.hide();
                    contentModal.year.prop('readonly', false);

                })

                $('.contentEdit').on('click', (ev) => {
                    contentModal.form[0].reset();
                    contentModal.addBtn.hide();
                    contentModal.updateBtn.show();

                    var index = $(ev.currentTarget).data('index');
                    currentData = dataContent[index];
                    contentModal.year.val(currentData['year']);
                    contentModal.year.prop('readonly', true);
                    contentModal.nominal.val(currentData['nominal']);
                    contentModal.dataId.val(currentData['id']);
                    contentModal.self.modal('show');
                    console.log(dataContent[index])

                })
                contentModal.form.on('submit', function(event, action) {
                    event.preventDefault()
                    var url = contentModal.addBtn.is(':visible') ? '{{ route('ins_budget.store') }}' :
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
                            url: '{{ route('ins_budget.store') }}',
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
