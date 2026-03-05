document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("iconInput");
    const preview = document.getElementById("imagePreview");
    const iconDataInput = document.getElementById("iconData");

    // Create modal container for the editor (you can style this with CSS)
    let editorModal = document.createElement("div");
    editorModal.id = "editorModal";
    editorModal.style.position = "fixed";
    editorModal.style.top = "0";
    editorModal.style.left = "0";
    editorModal.style.width = "100vw";
    editorModal.style.height = "100vh";
    editorModal.style.backgroundColor = "rgba(0,0,0,0.7)";
    editorModal.style.display = "none";
    editorModal.style.justifyContent = "center";
    editorModal.style.alignItems = "center";
    editorModal.style.zIndex = "9999";

    // Inner container for editor and buttons
    editorModal.innerHTML = `
                    <div style="width: 80vw; height: 80vh; background: white; position: relative; display: flex; flex-direction: column;">
                    <div id="tuiImageEditorContainer" style="flex-grow: 1;"></div>
                    <div style="padding: 10px; text-align: right;">
                        <button id="cancelEditBtn" class="btn btn-secondary">Cancel</button>
                        <button id="applyEditBtn" class="btn btn-primary">Apply</button>
                    </div>
                    </div>
                    `;

    document.body.appendChild(editorModal);

    let imageEditor = null;

    input.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("Please select a valid image file.");
            input.value = "";
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            // Show modal
            editorModal.style.display = "flex";

            // Initialize editor or reset if already exists
            if (imageEditor) {
                imageEditor.destroy();
                imageEditor = null;
            }

            imageEditor = new tui.ImageEditor(
                document.getElementById("tuiImageEditorContainer"),
                {
                    includeUI: {
                        loadImage: {
                            path: e.target.result,
                            name: file.name,
                        },
                        theme: {}, // default theme
                        menu: [
                            "crop",
                            "resize",
                            "flip",
                            "rotate",
                            "draw",
                            "shape",
                            "icon",
                            "text",
                            "mask",
                            "filter",
                        ],
                        initMenu: "crop",
                        menuBarPosition: "bottom",
                    },
                    cssMaxWidth: 700,
                    cssMaxHeight: 500,
                    selectionStyle: {
                        cornerSize: 20,
                        rotatingPointOffset: 70,
                    },
                },
            );

            // Remove the default "Download" button from UI
            setTimeout(() => {
                const downloadBtn = document.querySelector(
                    ".tui-image-editor-download-btn",
                );
                if (downloadBtn) {
                    downloadBtn.style.display = "none";
                }
            }, 500);
        };
        reader.readAsDataURL(file);
    });

    // Cancel button closes modal, clears input, no change
    document.getElementById("cancelEditBtn").addEventListener("click", () => {
        editorModal.style.display = "none";
        if (imageEditor) {
            imageEditor.destroy();
            imageEditor = null;
        }
        input.value = "";
    });

    // Apply button gets edited image and updates preview + hidden input
    document.getElementById("applyEditBtn").addEventListener("click", () => {
        if (!imageEditor) return;

        // Get dataURL (base64) of edited image
        const dataURL = imageEditor.toDataURL();

        // Set hidden input value and preview src
        iconDataInput.value = dataURL;
        preview.src = dataURL;

        // Close modal and destroy editor instance
        editorModal.style.display = "none";
        imageEditor.destroy();
        imageEditor = null;
    });
});
