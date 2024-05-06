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
                <div class="widget-content widget-content-area">
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
                    <div class="text-start">
                        <!-- Button trigger modal -->
                        {{-- @if (empty($dipas)) --}}
                        <a href="{{ route('budget_implementation.create') }}" class="btn btn-primary btn-md w-20">
                            Buat Usulan Baru
                        </a>
                        {{-- @endif --}}
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" style="width:40px;">No.</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Tahun</th>
                                    <th scope="col">Revisi ke</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dipas as $dipa)
                                    <tr>
                                        <td style="width:40px;">{{ $loop->iteration }}</td>
                                        <td>{{ $dipa->created_at }}</td>
                                        <td>{{ $dipa->year }}</td>
                                        <td>{{ $dipa->revision }}</td>
                                        <td>{{ number_format($dipa->total) }}</td>
                                        <td>{{ statusDipa($dipa->status) }}</td>
                                        <td class="text-center">
                                            @if (!empty($btnRPD))
                                                <a href="{{ route('withdrawal_plan.open', $dipa->id) }}"
                                                    class="btn btn-primary btn-sm" role="button">
                                                    <i class="text-white" data-feather="eye"></i>
                                                </a>
                                            @elseif (!empty($btnRekap))
                                                <a href="{{ route('activity_recap.open', $dipa->id) }}"
                                                    class="btn btn-primary btn-sm" role="button">
                                                    <i class="text-white" data-feather="eye"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                                    role="button" onclick="confirmDelete2({{ $dipa->id }});">
                                                    <i class="text-white" data-feather="trash-2"></i>
                                                </a>
                                                <a href="{{ route('dipa.update', $dipa->id) }}"
                                                    class="btn btn-primary btn-sm" role="button">
                                                    <i class="text-white" data-feather="eye"></i>
                                                </a>
                                                <a href="{{ route('dipa.fpdf', $dipa->id) }}"
                                                    class="btn btn-primary btn-sm" role="button">
                                                    <i class="text-white" data-feather="printer"></i>
                                                </a>
                                                <a href="{{ route('dipa.cetak', $dipa->id) }}" target="_blank"
                                                    class="btn btn-primary btn-sm" role="button">
                                                    <i class="text-white" data-feather="printer"></i>
                                                </a>
                                                @if ($dipa->status == 'accept')
                                                    <a href="{{ route('dipa.create-revisi', $dipa->id) }}"
                                                        class="btn btn-primary btn-sm" role="button">
                                                        Buat Revisi
                                                    </a>
                                                @endif
                                            @endif
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
                    <h5 class="modal-title" id="exampleModalCenterTitle">Input IKU
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
                            <div class="col-sm-12">
                                <select class="form-select @error('misi') is-invalid @enderror" id="selectTypeRole"
                                    name="misi" required>
                                    <option selected disabled value="">Pilih Misi...</option>
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
                            <label for="iku" class="ms-2 py-0 mb-0">IKU</label>
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
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })

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
                        deleteIKU(index);
                    }
                });
            }


            function deleteIKU(index) {
                // Assuming you have a route defined in Laravel to handle the deletion that expects the index
                axios.post("{{ route('dipa.delete') }}", {
                        id: index
                    })
                    .then(function(response) {
                        console.log(response);
                        // Handle success (e.g., show a success message and remove the row from the table)
                        Swal.fire(
                            'Dihapus!',
                            'DIPA telah dihapus.',
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
                            'Terjadi gangguan saat menghapus DIPA.',
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
