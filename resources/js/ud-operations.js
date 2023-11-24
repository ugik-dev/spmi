export function setupEditModal(
  editModalSelector,
  formSelector,
  actionUrlPattern,
  modelDataAttribute
) {
  const $editModal = $(editModalSelector);
  const $form = $(formSelector);

  $editModal.on("show.bs.modal", (event) => {
    const $button = $(event.relatedTarget);
    const modelData = $button.data(modelDataAttribute);
    const actionUrl = actionUrlPattern.replace(":id", modelData.id);

    $form.attr("action", actionUrl);

    Object.keys(modelData).forEach((key) => {
      $form.find(`[name="${key}"]`).val(modelData[key]);
    });
  });
}

export function setupDeleteFunctionality(
  tableSelector,
  deleteEndpointPattern,
  modelNameAttribute
) {
  const $table = $(tableSelector);

  $table.on("click", ".delete-button", (event) => {
    const $button = $(event.currentTarget);
    const modelId = $button.data("id");
    const modelName = $button.data(modelNameAttribute);
    const deleteUrl = deleteEndpointPattern.replace(":id", modelId);

    Swal.fire({
      title: "Apakah anda yakin?",
      text: `Anda akan menghapus ${modelName}. Tindakan ini tidak bisa dibatalkan.`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak, batalkan!",
      showLoaderOnConfirm: true,
      preConfirm: () => deleteData(deleteUrl),
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Dihapus!", `${modelName} sudah dihapus.`, "success");
        $table.DataTable().ajax.reload(null, false);
      }
    });
  });

  function deleteData(url) {
    return axios.delete(url).catch((error) => {
      Swal.fire("Kesalahan!", "Terjadi kesalahan saat penghapusan.", "error");
    });
  }
}
