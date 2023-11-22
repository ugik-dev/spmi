$(function () {
  const $usersTable = $("#users-datatable").DataTable({
    order: [0, "asc"],
  });

  const $editModal = $("#editModal");
  const $formEdit = $("#edit-form");
  const $userNameInput = $("#user-name");
  const $userEmailInput = $("#user-email");
  const $userRoleSelect = $("#user-role");

  $editModal.on("show.bs.modal", (event) => {
    const $buttonEdit = $(event.relatedTarget);
    const userData = $buttonEdit.data("user");
    const actionUrl = `/pengguna/edit/${userData.id}`;

    $formEdit.attr("action", actionUrl);
    $userNameInput.val(userData.name);
    $userEmailInput.val(userData.email);
    $userRoleSelect.val(userData.roles?.[0]?.name || "");
  });

  $usersTable.on("click", ".delete-button", (event) => {
    const $buttonDelete = $(event.currentTarget);
    const userId = $buttonDelete.data("id");
    const userName = $buttonDelete.data("username");

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
    }).then((result) => {
      setTimeout(() => window.location.reload(), 550);
    });
  });

  function deleteUserData(userId) {
    return axios
      .delete(`/pengguna/hapus/${userId}`)
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
  }
});
