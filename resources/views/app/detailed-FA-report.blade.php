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
                                    <th scope="col">Unit Kerja</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dipas as $dipa)
                                    <tr>
                                        <td style="width:40px;">{{ $loop->iteration }}</td>
                                        <td>{{ $dipa->created_at }}</td>
                                        <td>{{ $dipa->year }}</td>
                                        <td>{{ $dipa->timeline->category == 'pra-creat' ? 'Indikatif' : $dipa->revision }}
                                        <td>{{ number_format($dipa->total) }}</td>
                                        <td>{{ statusDipa($dipa->status) }}</td>
                                        <td>{{ $dipa->unit->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('detailed-FA-report.excel', $dipa->id) }}"
                                                class="btn btn-primary btn-sm" role="button">
                                                <i class="text-white" data-feather="eye"></i>
                                            </a>
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
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/editors/quill/quill.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>

        <script>
            window.addEventListener('load', function() {
                feather.replace();
            })

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
