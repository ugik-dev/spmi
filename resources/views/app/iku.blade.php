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
        <style>
            .table-hover tbody tr:hover {
                background-color: #f5f5f5;
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
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>

                    <div class="text-center d-flex justify-content-between align-items-center px-4">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-md w-20" data-bs-toggle="modal"
                            data-bs-target="#exampleModalCenter">
                            Input Sasaran Program
                        </button>
                    </div>

                    <div class="table-responsive px-4">
                        <table id="iku-table" class="table table-bordered table-hover">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Misi</th>
                                    <th scope="col">Sasaran Program</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ikus as $iku)
                                    <tr>
                                        <td style="width:40px;">{{ $loop->iteration }}</td>
                                        <td>{{ $iku->mission?->description }}</td>
                                        <td>{{ $iku->description }}</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" role="button"
                                                onclick="confirmDelete2({{ $iku->id }});">
                                                <i class="text-white" data-feather="trash-2"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-primary"
                                                onclick="openEditModal({{ $iku->id }}, '{{ $iku->description }}','{{ $iku->renstra_mission_id }}')">
                                                <i class="text-white" data-feather="edit-2"></i>
                                            </button>
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
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input Sasaran Program
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
                    <form action="{{ route('iku.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 row align-items-center">
                            <div class="col-sm-12" id="WrapperSelect2">
                                <select class="form-select select2 @error('misi') is-invalid @enderror w-100"
                                    style="width: 100% !important" name="misi" id="MisiSelect2">
                                    <option selected value="">Pilih Misi...</option>
                                    @foreach ($missions as $mission)
                                        <option value="{{ $mission->id }}"
                                            {{ old('misi') == $mission->id ? 'selected' : '' }}>
                                            {{ $mission->description }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('misi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <button type="button" id="add-iku" class="btn btn-sm btn-primary py-0 px-2">
                                <i data-feather="plus"></i>
                            </button>
                            <label for="iku" class="ms-2 py-0 mb-0">Sasaran Program</label>
                        </div>

                        <div id="iku-inputs" class="mt-2">
                            <div class="input-group mb-2">
                                <span class="input-group-text">1.</span>
                                <input type="text" name="iku[]" class="form-control">
                                <button type="button" class="btn btn-danger remove-iku">
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalTitle">Edit Sasaran Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Description</label>
                            {{-- <input type="text" id="iku_id_edit" name="id" class="form-control" required> --}}
                            <input type="text" id="iku_description_edit" name="description" class="form-control"
                                required>
                        </div>
                        <div class="form-group mt-3">
                            <label>Misi</label>
                            <select style="width: 100% important"
                                class="form-select @error('misi') is-invalid @enderror " id="iku_misi_edit"
                                name="misi">
                                <option selected value="">Pilih Misi...</option>
                                @foreach ($missions as $mission)
                                    <option value="{{ $mission->id }}"
                                        {{ old('misi') == $mission->id ? 'selected' : '' }}>
                                        {{ $mission->description }}
                                    </option>
                                @endforeach
                            </select>
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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })
            $('#MisiSelect2').select2({
                dropdownParent: $('#WrapperSelect2'),
            })


            $('#iku_misi_edit').select2({
                dropdownParent: $('#editModal'),
            })

            function openEditModal(id, desc, mision) {
                // Populate the form fields
                // document.getElementById('iku_id_edit').value = name;
                document.getElementById('iku_misi_edit').value = mision;
                document.getElementById('iku_description_edit').value = desc;
                // document.getElementById('performance_indicator_value_end').value = value_end;
                // Update the form action URL
                document.getElementById('edit-form').action = '/admin/renstra/iku/' + id + '/update';

                // Show the modal
                new bootstrap.Modal(document.getElementById('editModal')).show();
            }

            function confirmDelete2(index) {
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
                        deleteSasaranProgram(index);
                    }
                });
            }


            function deleteSasaranProgram(index) {
                // Assuming you have a route defined in Laravel to handle the deletion that expects the index
                axios.post("{{ route('iku.delete') }}", {
                        id: index
                    })
                    .then(function(response) {
                        console.log(response);
                        // Handle success (e.g., show a success message and remove the row from the table)
                        Swal.fire(
                            'Dihapus!',
                            'Sasaran Program telah dihapus.',
                            'success'
                        ).then(() => {
                            window.location.reload(); // or use JavaScript to remove the row from the DOM
                        });
                    })
                    .catch(function(error) {
                        console.log(error);
                        // Handle error (e.g., show an error message)
                        Swal.fire(
                            'Gangguan!',
                            'Terjadi gangguan saat menghapus iku.',
                            'error'
                        );
                    });
            }

            function updateNumbering() {
                const ikuInputs = document.querySelectorAll('#iku-inputs .input-group');
                ikuInputs.forEach((input, index) => {
                    input.querySelector('.input-group-text').textContent = `${index + 1}.`;
                });
            }
            document.addEventListener('DOMContentLoaded', function() {
                $('#iku-table').DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex flex-column flex-sm-row justify-content-center align-items-center justify-content-sm-end mt-sm-0 mt-3'Bf>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "buttons": [{
                            text: 'PDF',
                            className: 'buttons-pdf buttons-html5 btn btn-danger',
                            action: function(e, dt, node, config) {
                                window.location.href = "{{ route('download.iku.pdf') }}";
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
                                return 'Sasaran_Program_Excel' + n;
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

                const ikuContainer = document.getElementById('iku-inputs');

                document.getElementById('add-iku').addEventListener('click', function() {
                    const newInput = `<div class="input-group mb-2">
                        <span class="input-group-text"></span>
                        <input type="text" name="iku[]" class="form-control">
                        <button type="button" class="btn btn-danger remove-iku">
                            <i data-feather="trash"></i>
                        </button>
                      </div>`;
                    ikuContainer.insertAdjacentHTML('beforeend', newInput);
                    feather.replace();
                    updateNumbering();
                });

                ikuContainer.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-iku')) {
                        event.target.closest('.input-group').remove();
                        updateNumbering();
                    }
                });
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    </x-base-layout>
