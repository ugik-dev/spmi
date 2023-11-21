$("#users-datatable").DataTable({
  order: [0, "asc"],
});
$("#editModal").on("show.bs.modal", function (event) {
  var buttonEdit = $(event.relatedTarget);
  var userData = buttonEdit.data("user");

  var formEdit = $("#edit-form");
  var actionUrl = "/edit-pengguna/" + userData.id;

  // Fill the inputs inside edit form
  formEdit.attr("action", actionUrl);
  $("#user-name").val(userData.name);
  $("#user-email").val(userData.email);
  $("#user-role").val(userData.roles?.[0]?.name || "");
});

$("#users-datatable").on("click", ".delete-button", function (event) {
  var buttonDelete = $(this);
  var userId = buttonDelete.data("id");
  var userName = buttonDelete.data("username");

  Swal.fire({
    title: "Apakah anda yakin?",
    text: `Data pengguna (${userName}) akan dihapus!`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: "Batal",
    showLoaderOnConfirm: true,
    preConfirm: () => {
      return axios
        .delete(`/hapus-pengguna/${userId}`)
        .then((response) => {
          if (response.status === 200 || response.status === 204) {
            Swal.fire("Dihapus!", "Pengguna telah dihapus.", "success");
          } else {
            Swal.fire(
              "Gagal!",
              "Terjadi kesalahan saat menghapus pengguna.",
              "error"
            );
          }
        })
        .catch((error) => {
          Swal.showValidationMessage(`Request failed: ${error}`);
        });
    },
    allowOutsideClick: () => !Swal.isLoading(),
  }).then((result) => {
    if (result.isConfirmed) {
      setTimeout(() => {
        location.reload();
      }, 850);
    }
  });
});
