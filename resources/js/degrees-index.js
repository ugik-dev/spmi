$(function () {
  const $degreesTable = $("#degrees-datatable").DataTable({
    order: [0, "asc"],
  });

  const $editModal = $("#editDegreeModal");
  const $formEdit = $("#edit-degree-form");
  const $degreeNameInput = $("#degree-name");
  const $degreeCodeInput = $("#degree-code");

  $editModal.on("show.bs.modal", (event) => {
    const $buttonEdit = $(event.relatedTarget);
    const degreeData = $buttonEdit.data("degree");
    const actionUrl = `/jenjang/edit/${degreeData.id}`;

    $formEdit.attr("action", actionUrl);
    $degreeNameInput.val(degreeData.name);
    $degreeCodeInput.val(degreeData.code);
  });

  $degreesTable.on("click", ".delete-button", (event) => {
    const $buttonDelete = $(event.currentTarget);
    const degreeId = $buttonDelete.data("id");
    const degreeName = $buttonDelete.data("degree-name");

    Swal.fire({
      title: "Apakah anda yakin?",
      text: `Data jenjang (${degreeName}) akan dihapus!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
      showLoaderOnConfirm: true,
      preConfirm: () => deleteDegreeData(degreeId),
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.isConfirmed) {
        setTimeout(() => window.location.reload(), 550);
      }
    });
  });

  function deleteDegreeData(degreeId) {
    return axios
      .delete(`/jenjang/hapus/${degreeId}`)
      .then((response) => {
        if (response.status === 200 || response.status === 204) {
          Swal.fire("Dihapus!", "Jenjang telah dihapus.", "success");
        } else {
          Swal.fire(
            "Gagal!",
            "Terjadi kesalahan saat menghapus degree.",
            "error"
          );
        }
      })
      .catch((error) => {
        Swal.showValidationMessage(`Request failed: ${error}`);
      });
  }
});
