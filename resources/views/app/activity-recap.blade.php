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
        <link rel="stylesheet" href="{{ asset('plugins/filepond/filepond.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/filepond/FilePondPluginImagePreview.min.css') }}">
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
        <style>
            .filepond--root {
                font-size: 16px;
                border-radius: 0.375rem;
                border: 1px solid #ced4da;
            }

            .filepond--drop-label {
                color: #495057;
                background-color: #e9ecef;
                padding: 10px;
                white-space: pre-wrap;
                text-align: center;
                border-bottom: 1px solid #ced4da;
            }

            .filepond--label-action {
                text-decoration: none;
                font-weight: bold;
                color: #007bff;
                /* Bootstrap primary color */
            }

            .filepond--panel-root {
                border-radius: 0.375rem;
            }

            .filepond--item {
                background-color: #f8f9fa;
                border-radius: 0.25rem;
                margin-bottom: 5px;
                border: 1px solid #ced4da;
            }

            .btn-outline-danger .feather-upload {
                stroke: #ff0000;
                /* Normal state color */
            }

            .btn-outline-danger:hover .feather-upload {
                stroke: white;
                /* Hover state color */
            }

            .btn-outline-success .feather-upload {
                stroke: #00ab55;
                /* Normal state color */
            }

            .btn-outline-success:hover .feather-upload {
                stroke: white;
            }


            .recap-description:hover {
                background-color: lightyellow;
                cursor: pointer;
                color: black;
                opacity: 1;
            }

            .recap-description {
                transition: 0.305s ease-in-out all;
                opacity: 0.95;
            }

            .valid-row td {
                background-color: #00ab55;
                color: white;
            }

            .valid-row button.btn-success {
                background: white;
                color: #00ab55 !important;
            }

            .valid-row button.btn-success:hover {
                background: black !important;
                color: white !important;
            }

            .invalid-row button.btn-danger {
                background: white;
                color: #e7515a !important;
            }

            .invalid-row button.btn-danger:hover {
                background: black !important;
                color: white !important;
            }

            .invalid-row td {
                background-color: #e7515a;
                color: white;
            }

            .invalid-row .feather-upload.accept {
                stroke: white;
            }

            .invalid-row button.btn-success:hover .feather-upload.accept {
                stroke: blue;
            }

            .invalid-row button.btn-success:hover .icon-name {
                color: blue !important;
            }

            .invalid-row button.btn-success:hover {
                background: white !important;
            }

            .valid-row .feather-upload.reject {
                stroke: white;
            }

            .valid-row button.btn-danger:hover .feather-upload.reject {
                stroke: blue;
            }

            .valid-row button.btn-danger:hover .icon-name {
                color: blue !important;
            }

            .valid-row button.btn-danger:hover {
                background: white !important;
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
                <div class="table-responsive my-4">
                    <table id="activity_recap-table" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Kode</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Total</th>
                                <th scope="col">Upload Data Dukung</th>
                                {{-- <th style="width:20rem" scope="col">Aksi</th> --}}
                                {{-- <th scope="col">Keterangan</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                <tr class="{{ $activity->activityRecap?->is_valid ? 'valid-row' : 'invalid-row' }}">
                                    <td id="activity-{{ $activity->id }}">{{ $activity->code }}</td>
                                    <td>{{ $activity->name }}</td>
                                    <td>{{ $activity->calculateTotalSumFormatted() }}</td>
                                    <td>
                                        <div
                                            class="d-flex flex-column flex-sm-row align-items-center justify-content-center">

                                        </div>
                                        @if ($activity->activityRecap && $activity->activityRecap?->attachment_path)
                                            @php
                                                $filePath = Storage::disk(
                                                    App\Supports\Disk::ActivityRecapAttachment,
                                                )->path($activity->activityRecap?->attachment_path);
                                                $fileMimeType = mime_content_type($filePath);
                                            @endphp
                                            <div
                                                class="d-flex flex-column flex-sm-row align-items-center justify-content-center">

                                                <button type="button"
                                                    class="btn btn-primary btn-sm me-sm-2 mb-2 mb-sm-0"
                                                    onclick="handleViewFile('{{ route('activity-recap.show-file', $activity->activityRecap) }}', '{{ $fileMimeType }}');">
                                                    <i class="feather icon-eye"></i> Lihat File
                                                </button>

                                                {{-- "Change File" Button --}}
                                                <button type="button" data-activity-id="{{ $activity->id }}"
                                                    class="btn btn-secondary btn-sm ms-2 uploadBerkasBtn"
                                                    data-replace="{{ !empty($activity->activityRecap->attachment_path) ? 'Y' : 'N' }}">
                                                    <i class="feather icon-edit"></i>
                                                    {{ !empty($activity->activityRecap->attachment_path) ? 'Ganti File' : 'Upload File' }}
                                                </button>
                                            </div>

                                            {{-- Hidden FilePond Input --}}
                                        @else
                                            <button type="button" data-activity-id="{{ $activity->id }}"
                                                class="btn btn-secondary btn-sm ms-2 uploadBerkasBtn">
                                                <i class="feather icon-edit"></i> Upload File
                                            </button>
                                        @endif
                                    </td>


                                    {{-- <td style="width: 15rem">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <button type="button"
                                                class=" btn btn-sm btn-danger text-center d-flex justify-content-center align-items-center gap-1 update-status"
                                                data-activity-id="{{ $activity->id }}" data-new-status="0">
                                                <i data-feather="x-square" class="feather-upload reject"></i><span
                                                    class="icon-name">Tolak</span>
                                            </button>
                                            <button type="button"
                                                class="btn btn-sm btn-success text-center d-flex justify-content-center align-items-center gap-1 update-status"
                                                data-activity-id="{{ $activity->id }}" data-new-status="1">
                                                <i data-feather="check-square" class="feather-upload accept"></i><span
                                                    class="icon-name">Terima</span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="recap-description">
                                        {{ $activity->activityRecap?->description ?? '' }}
                                    </td> --}}
                                </tr>
                            @empty
                            @endforelse
                        </tbody>

                    </table>
                    <div class="text-end">
                    </div>
                </div>

            </x-custom.statbox>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalTitle"
        aria-hidden="true" data-bs-focus="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalTitle">Upload Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="form-upload" action="{{ route('activity_recap.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <input name="activityId" id="activityId" value="" type="hidden">
                        <div class="mb-4 row">
                            <label for="inputDisbursementDescription" class="col-sm-2 col-form-label">Pilih File</label>
                            <div class="col-sm-8">
                                <input accept=".pdf" class="form-control" type="file" name="file_upload"
                                    id="file_upload"></input>
                                <span class="text-danger">*max 20Mb</span>
                                <span class="text-danger" id="label-warning-gantifile"><b>*Mengganti file akan
                                        menyebabkan status dipa menjadi draft
                                        atau mengulang kembali prosedur!</b></span>
                            </div>
                        </div>
                        <button id="submitFormupload"
                            class="btn btn-warning text-center align-items-center mt-2 py-auto" type="submit">
                            <span class="icon-name">Simpan</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{ asset('plugins/global/vendors.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts2/sweetalerts2.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepond.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/FilePondPluginFileValidateType.min.js') }}"></script>
        <script src="{{ asset('plugins/filepond/filepondPluginFileValidateSize.min.js') }}"></script>
        <script>
            let ponds = [];

            function showFilePondInput(activityId) {
                var filePondInput = document.getElementById('filepond-' + activityId);
                if (filePondInput) {
                    $(filePondInput).toggleClass('d-none');
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                FilePond.registerPlugin(
                    FilePondPluginFileValidateType,
                    FilePondPluginFileValidateSize
                );
                FilePond.setOptions({
                    labelIdle: `<span class="filepond--label-action"><i data-feather="upload"></i> Upload Data Dukung</span>`
                });

                const theadTh = document.querySelectorAll('thead tr th');
                const fileInputs = document.querySelectorAll('.filepond');
                const recapDescriptions = document.querySelectorAll('.recap-description');
                const trActivityRecaps = document.querySelectorAll('tbody tr');
                const btnSave = document.getElementById('save-activity_recap');

                $('.uploadBerkasBtn').on('click', function(ev) {
                    currentID = $(this).data('activity-id');
                    $('#uploadModal').modal('show')
                    $('#uploadModal').find('#activityId').val(currentID);
                    replaceFile = $(this).data('replace');
                    if (replaceFile == 'Y') {
                        $('#label-warning-gantifile').show();
                    } else {
                        $('#label-warning-gantifile').hide();

                    }
                    console.log(currentID);

                });
                $('#form-upload').submit(function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);
                    var url = $(this).attr('action');

                    // Tampilkan loading modal sebelum proses pengiriman dimulai
                    var swalLoading = Swal.fire({
                        title: 'Loading...',
                        html: 'Upload Progress: <b></b>%',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonText: 'Batal Unggah',
                        willOpen: () => {
                            // Swal.showLoading();
                        }
                    });

                    var xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percent = (event.loaded / event.total) * 100;
                            // Perbarui teks pada SweetAlert dengan persentase yang sesuai
                            // Swal.getHtmlContainer().textContent =
                            //     'Upload Progress: ' + percent.toFixed(2) + '%';
                            const b = Swal.getHtmlContainer().querySelector('b')
                            // timerInterval = setInterval(() => {
                            b.textContent = percent.toFixed(2)
                            // }, 100)
                        }
                    });

                    xhr.addEventListener('load', function(event) {
                        if (xhr.status === 200) {
                            Swal.fire({
                                title: 'Success',
                                text: 'File uploaded successfully',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                location
                                    .reload();
                                window.location.href = window.location.href +
                                    '#document';
                            });
                        } else {
                            var errorResponse = JSON.parse(xhr.responseText);
                            Swal.fire({
                                title: 'Error!',
                                text: errorResponse.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    });

                    xhr.addEventListener('error', function(event) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while uploading the file',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    });

                    xhr.open('POST', url);
                    swalLoading.then((result) => {
                        if (result.dismiss === Swal.DismissReason.cancel) {
                            xhr.abort(); // Batalkan pengiriman Ajax jika tombol "Batal Unggah" diklik
                        }
                    });
                    xhr.send(formData);

                });

                theadTh.forEach(th => th.classList.add('bg-primary'));

                // Event listener for status update buttons
                document.querySelectorAll('.update-status').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var activityId = this.getAttribute('data-activity-id');
                        var newStatus = this.getAttribute('data-new-status');

                        updateActivityStatus(activityId, newStatus);
                    });
                });

                fileInputs.forEach(inputElement => {
                    // Create FilePond instance
                    const pond = FilePond.create(inputElement, {
                        acceptedFileTypes: [
                            'application/pdf',
                            '.rar',
                            'application/zip',
                            'application/octet-stream' // Additional MIME type for ZIP files
                        ],
                        fileValidateTypeLabelExpectedTypesMap: {
                            'application/pdf': '.pdf',
                            'application/zip': '.zip',
                            'application/octet-stream': '.zip',
                            '.rar': 'RAR Archive'
                        }
                    });
                    ponds.push(pond);
                    setTimeout(() => feather.replace(), 0);
                });
                recapDescriptions.forEach(function(cell) {
                    cell.addEventListener('click', function() {
                        // Make the cell editable when clicked
                        cell.setAttribute('contenteditable', 'true');
                        cell.focus(); // Optional: to immediately focus the cell
                    });

                    cell.addEventListener('blur', function() {
                        // Remove the contenteditable attribute when focus is lost
                        cell.removeAttribute('contenteditable');

                        const editedText = cell.innerText;
                    });
                });
                btnSave.addEventListener('click', handleSaveActivityRecapRows);

                async function handleSaveActivityRecapRows() {
                    let formData = new FormData();

                    trActivityRecaps.forEach((row, index) => {
                        // Get the corresponding FilePond instance
                        const pond = ponds[index];
                        if (pond && pond.getFiles().length > 0) {
                            const file = pond.getFiles()[0].file;
                            formData.append(`files[${index}]`, file, file.name);
                        }

                        // Get activity ID from the first cell
                        const activityID = row.querySelector('td:first-child').id.replace('activity-', '');

                        // Get description from the recap-description cell
                        let descriptionEl = row.querySelector('.recap-description');
                        const description = descriptionEl ? descriptionEl.textContent : '';

                        formData.append(`activityIDs[${index}]`, activityID);
                        formData.append(`descriptions[${index}]`, description);
                    });

                    // Axios POST request
                    try {
                        const response = await axios.post('{{ route('activity_recap.store') }}', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Berhasil menyimpan data rekap kegiatan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reload the window when the user clicks "OK"
                            window.location.reload();
                        });
                    } catch (error) {
                        Swal.fire({
                            title: 'Gangguan!',
                            text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }

                // Function to send AJAX request to update status
                function updateActivityStatus(activityId, newStatus) {
                    axios.post('{{ route('activity_recap.update_status') }}', {
                            activity_id: activityId,
                            is_valid: newStatus
                        })
                        .then(function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Berhasil mengubah status validitas.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Reload the window when the user clicks "OK"
                                window.location.reload();
                            });
                        })
                        .catch(function(error) {
                            Swal.fire({
                                title: 'Gangguan!',
                                text: 'Terjadi kesalahan. Silahkan coba sesaat lagi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                }


            });

            function handleViewFile(url, mimeType) {
                if (mimeType === 'application/pdf' || mimeType === 'image/jpeg') {
                    // Membuka file dalam tab baru jika PDF atau gambar
                    window.open(url, '_blank');
                } else if (mimeType === 'application/zip') {
                    // Mengunduh file jika zip
                    window.location.href = url;
                }
            }
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-custom.app-layout>
