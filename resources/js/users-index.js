$(function () {
  const $usersTable = $("#users-table").DataTable();

  const $editModal = $("#editModal");
  const $formEdit = $("#edit-form");
  const $userNameInput = $("#user-name");
  const $userEmailInput = $("#user-email");
  const $userRoleSelect = $("#user-role");

  $editModal.on("show.bs.modal", (event) => {
    const $buttonEdit = $(event.relatedTarget);
    const userData = $buttonEdit.data("model");
    const actionUrl = `/pengguna/edit/${userData.id}`;

    $formEdit.attr("action", actionUrl);
    $userNameInput.val(userData.name);
    $userEmailInput.val(userData.email);
    $userRoleSelect.val(userData.roles?.[0]?.name || "");
  });

  $usersTable.on("click", ".delete-button", function () {
    const $buttonDelete = $(this);
    const userId = $buttonDelete.data("id");
    const userName = $buttonDelete.data("model-name");

    Swal.fire({
      title: "Apakah anda yakin?",
      text: `Data pengguna (${userName}) akan dihapus!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
      showLoaderOnConfirm: true,
      preConfirm: () => deleteUserData(userId),
      allowOutsideClick: () => !Swal.isLoading(),
    });
  });

  function deleteUserData(userId) {
    return axios
      .delete(`/pengguna/hapus/${userId}`)
      .then((response) => {
        if (response.status === 200 || response.status === 204) {
          Swal.fire("Dihapus!", "Pengguna telah dihapus.", "success");
          reloadTable();
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
  }
  function reloadTable() {
    $usersTable.ajax.reload(null, false); // Reload the DataTable without resetting the paging
  }
});
