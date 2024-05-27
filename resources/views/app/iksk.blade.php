<x-custom.app-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{ $title }}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/animate/animate.css') }}">
        @vite(['resources/scss/light/assets/elements/alert.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])
        <link rel="stylesheet" href="{{ asset('plugins/sweetalerts2/sweetalerts2.css') }}">
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
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

            td {
                white-space: normal !important;
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

            .select2-container--open {
                z-index: 999999 !important;
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
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input Indikator Kinerja Sasaran Kegiatan
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="iksk-table" class="table table-bordered">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Sasaran Kegiatan</th>
                                    <th scope="col">Indikator Kinerja Sasaran Kegiatan</th>
                                    <th scope="col">Target</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($perforceHasIksk as $index => $performanceIksk)
                                    @foreach ($performanceIksk->iksks as $iksk)
                                        <tr>
                                            <td>{{ $loop->parent->iteration }}</td>
                                            <td>{{ $performanceIksk->name }}</td>
                                            <td>{{ $iksk->name }}</td>
                                            <td>
                                                @if ($iksk->type == 'decimal')
                                                    {{ number_format((float) $iksk->value, 2, '.') }}
                                                @elseif ($iksk->type == 'persen')
                                                    {{ (int) $iksk->value }}%
                                                @elseif ($iksk->type == 'range')
                                                    {{ number_format((float) $iksk->value, 2, '.') }} -
                                                    {{ number_format((float) $iksk->value_end, 2, '.') }}
                                                @endif
                                            </td>
                                            <td class="d-flex justify-content-center text-start">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="openEditModal({{ $iksk->id }}, '{{ $iksk->name }}','{{ number_format((float) $iksk->value, 2, '.') }}','{{ $iksk->type }}','{{ $iksk->value_end }}')">
                                                    <i class="text-white" data-feather="edit-2"></i>
                                                </button>

                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm mx-1"
                                                    role="button" onclick="confirmDelete({{ $iksk->id }});">
                                                    <i class="text-white" data-feather="trash-2"></i>
                                                </a>
                                                <!-- Hidden form for delete request -->
                                                <form id="delete-form-{{ $iksk->id }}"
                                                    action="{{ route('iksk.delete', $iksk->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data IKSK masih kosong..</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $perforceHasIksk->links() }} --}}
                        <!-- Pagination -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Indikator Kinerja Sasaran Kegiatan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18">
                            </line>
                            <line x1="6" y1="6" x2="18" y2="18">
                            </line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('iksk.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="performance_indicator">Sasaran Kegiatan</label>
                            <select id="performance_indicator" name="performance_indicator_id"
                                class="form-control select2">
                                <option value="">Pilih Sasaran Kegiatan</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>

                        <div class="form-group d-flex align-items-center my-2">
                            <button type="button" id="add-iksk" class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <label for="iksk" class="ms-2 py-0 mb-0">Indikator Kinerja Sasaran Kegiatan</label>
                        </div>

                        <div id="iksk-inputs" class="mt-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">1.</span>
                                <input type="text" name="iksk[]" class="form-control">
                                <button type="button" class="btn btn-danger remove-iksk">
                                    <i data-feather="trash"></i>
                                </button>
                            </div>
                        </div>

                        <button class="btn btn-success text-center align-items-center mt-1 mt-2 py-auto"
                            type="submit">
                            <i data-feather="save"></i><span class="icon-name">Simpan</span>
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Indikator Kinerja Sasaran Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Indikator Kinerja Sasaran Kegiatan</label>
                            <input type="text" id="performance_indicator_name" name="name"
                                class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Tipe</label>
                            <select type="text" name="type_value" id="type_value" class="form-control" required>
                                <option value="decimal">Desimal</option>
                                <option value="persen">Persentase (%)</option>
                                <option value="range">Range / Rentan</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label>Target</label>
                            <input type="text" id="performance_indicator_value" name="value"
                                class="form-control" required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Sampai</label>
                            <input type="text" id="performance_indicator_value_end" name="value_end"
                                class="form-control">
                        </div>

                        <!-- Add other fields as needed -->
                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/jszip.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('plugins-rtl/table/datatable/button-ext/buttons.print.min.js') }}"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            function openEditModal(id, name, value, type, value_end) {
                // Populate the form fields
                document.getElementById('performance_indicator_name').value = name;
                document.getElementById('performance_indicator_value').value = value;
                document.getElementById('type_value').value = type;
                document.getElementById('performance_indicator_value_end').value = value_end;
                // Update the form action URL
                document.getElementById('edit-form').action = '/admin/perkin/iksk/' + id + '/update';

                // Show the modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }


            function confirmDelete(id) {
                Swal.fire({
                    title: 'Anda yakin ingin hapus?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }

            function updateNumbering() {
                const missionInputs = document.querySelectorAll('#iksk-inputs .input-group');
                missionInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                $('#iksk-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            text: 'PDF',
                            className: 'buttons-pdf buttons-html5 btn btn-danger',
                            action: function(e, dt, node, config) {
                                window.location.href = "{{ route('download.iksk.pdf') }}";
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
                                return 'IKSK_Excel_' + n;
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
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });

                const missionContainer = document.getElementById('iksk-inputs');

                document.getElementById('add-iksk').addEventListener('click', function() {
                    const newInput = `<div class="input-group mb-2">
                            <span class="input-group-text"></span>
                            <input type="text" name="iksk[]" class="form-control">
                            <button type="button" class="btn btn-danger remove-iksk">
                                <i data-feather="trash"></i>
                            </button>
                        </div>`;
                    missionContainer.insertAdjacentHTML('beforeend', newInput);
                    feather.replace();
                    updateNumbering();
                });

                missionContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-iksk')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });
            });

            $('#exampleModalCenter').on('shown.bs.modal', function() {
                $('#performance_indicator').select2({
                    dropdownParent: $('#exampleModalCenter'),
                    placeholder: 'Pilih Sasaran Kegiatan',
                    theme: 'bootstrap-5',
                    ajax: {
                        transport: function(params, success, failure) {
                            // Using Axios to fetch the data
                            axios.get(`{{ route('performance_indicators.index') }}`, {
                                    params: {
                                        search: params.data.term,
                                        limit: 10
                                    }
                                })
                                .then(function(response) {
                                    // Call the `success` function with the formatted results
                                    success({
                                        results: response.data.map(function(item) {
                                            return {
                                                id: item.id,
                                                text: item.name
                                            };
                                        })
                                    });
                                })
                                .catch(function(error) {
                                    // Call the `failure` function in case of an error
                                    failure(error);
                                });
                        },
                        delay: 250,
                        cache: true
                    }
                });

            }).on('hidden.bs.modal', function() {
                $('#performance_indicator').select2('destroy');
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
