document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("iconInput");
    const preview = document.getElementById("imagePreview");
    const iconDataInput = document.getElementById("iconData");
    const MAX_WIDTH = 800;
    const MAX_HEIGHT = 800;

    // Resize image and remove background (white) before preview and submit
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
            const img = new Image();
            img.onload = function () {
                // Create canvas to resize and remove background
                const canvas = document.createElement("canvas");
                let width = img.width;
                let height = img.height;

                // Calculate new dimensions preserving aspect ratio
                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext("2d");

                // Draw white background (or transparent)
                ctx.clearRect(0, 0, width, height);
                // Optional: Remove white background by setting pixels with white color to transparent
                ctx.drawImage(img, 0, 0, width, height);

                // You can add image background removal here if you want (complex)
                // For now we just resize

                // Update preview image src
                preview.src = canvas.toDataURL(file.type);

                // Convert to Blob and then to Base64 to put in hidden input
                canvas.toBlob(
                    function (blob) {
                        const reader2 = new FileReader();
                        reader2.onloadend = function () {
                            iconDataInput.value = reader2.result; // base64 string to send in form
                        };
                        reader2.readAsDataURL(blob);
                    },
                    file.type,
                    0.9,
                );
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Smart description formatting (paste and blur)
    const textarea = document.getElementById("description");

    function smartFormat(text) {
        text = text.replace(/\r\n/g, "\n").replace(/\r/g, "\n");
        let lines = text.split("\n");
        lines = lines.map((line) => line.trim());

        let cleanedLines = [];
        let emptyCount = 0;
        for (let line of lines) {
            if (line === "") {
                emptyCount++;
                if (emptyCount <= 1) cleanedLines.push(line);
            } else {
                emptyCount = 0;
                cleanedLines.push(line);
            }
        }

        cleanedLines = cleanedLines.map((line) => {
            if (/^[-*•]\s+/.test(line)) {
                line = line.replace(/^([-*•])\s+/, "• ");
                line =
                    line[0] +
                    line.slice(1).replace(/^\w/, (c) => c.toUpperCase());
            } else if (/^\d+\.\s+/.test(line)) {
                line = line.replace(
                    /^(\d+\.\s+)(\w)/,
                    (m, p1, p2) => p1 + p2.toUpperCase(),
                );
            } else {
                line = line.replace(/^\w/, (c) => c.toUpperCase());
            }
            line = line
                .replace(/(^|[\s(\[{<])'/g, "$1‘")
                .replace(/'/g, "’")
                .replace(/(^|[\s(\[{<])"/g, "$1“")
                .replace(/"/g, "”");
            return line;
        });

        return cleanedLines.join("\n");
    }

    textarea.addEventListener("paste", function (e) {
        e.preventDefault();
        let pasteText = (e.clipboardData || window.clipboardData).getData(
            "text",
        );
        let formattedText = smartFormat(pasteText);
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const textBefore = textarea.value.substring(0, start);
        const textAfter = textarea.value.substring(end);
        textarea.value = textBefore + formattedText + textAfter;
        const cursorPos = start + formattedText.length;
        textarea.selectionStart = textarea.selectionEnd = cursorPos;
    });

    textarea.addEventListener("blur", function () {
        textarea.value = smartFormat(textarea.value);
    });
});
