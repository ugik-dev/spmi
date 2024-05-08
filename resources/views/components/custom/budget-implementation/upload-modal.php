@props(['receipt'])

<button type="button" class="btn btn-sm btn-primary temporary-edit mb-2 mt-2" data-bs-target="#uploadModal" data-bs-toggle="modal">
    <i data-feather="upload"></i> {{ $receipt->berkas ? 'Ganti Berkas' : 'Upload Berkas' }}
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>