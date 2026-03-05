function generateBarcode(id, button) {
    button.innerHTML = "Generating...";
    button.disabled = true;

    let csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/storages/${id}/generate-barcode`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                document.getElementById("barcodeSection").innerHTML = `
            
                <img src="/${data.barcode_path}"
                     class="img-fluid"
                     style="max-height:80px">

                <div class="mt-2">
                    <small class="text-muted">
                        ${data.barcode}
                    </small>
                </div>
            `;
            } else {
                alert("Failed to generate barcode");
            }
        })
        .catch((err) => {
            console.error(err);
            alert("Error generating barcode");
        });
}
