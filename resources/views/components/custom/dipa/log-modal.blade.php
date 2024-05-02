@props(['dipa'])

<button type="button" class="btn btn-sm btn-success temporary-edit mb-2 mt-2 log_btn" data-res="Y">
    <i data-feather="file-text"></i> Logs
</button>

<div class="modal fade c-modal-bg" id="logModal" tabindex="-1" role="dialog" aria-labelledby="rampungModalTitle"
    aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rampungModalTitle">Logs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td scope="text-center"><b>Waktu</b></td>
                                <td class="text-center" style="width: 300px"><b>User</b></td>
                                <td class="text-center"><b>Keterangan</b></td>
                                <td class="text-center"><b></b></td>
                            </tr>
                        </thead>
                        <tbody id="tableLog">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.log_btn').on('click', function(e) {
            e.preventDefault();
            var res = $(this).data('res');

            var swalLoading = Swal.fire({
                title: 'Loading...',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: '{{ route('dipa.log', $dipa) }}',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {},
                success: function(response) {
                    $('#tableLog').empty();

                    // Loop through each item in the response data array
                    response.data.forEach(function(item) {
                        console.log(item);
                        var row = $('<tr>');
                        var formattedDate = new Date(item.created_at)
                            .toLocaleString('en-US', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                        // Append cells with formatted data to the row
                        row.append($('<td>').text(formattedDate)); // Waktu
                        row.append($('<td>').text(item.user.name)); // User
                        row.append($('<td>').text(item.description)); // Keterangan

                        // Append the row to the table body
                        $('#tableLog').append(row);
                    });

                    $('#logModal').modal('show');
                    console.log(response);
                },
                error: function(response, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                },
                complete: function() {
                    swalLoading.close();
                }
            });

        });
    });
</script>
