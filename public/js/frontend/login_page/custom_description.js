/* =========================================
   PROBLEM DESCRIPTION EDITOR
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const field = document.querySelector(
        "#problem_description, #problemDescription, " +
            'textarea[name="description"], textarea[name="problem_description"]',
    );

    if (!field || field.dataset.descriptionInitialized === "true") {
        return;
    }

    field.dataset.descriptionInitialized = "true";

    const form = field.closest("form");

    if (!form) return;

    const MAX_WORDS = Number(field.dataset.maxWords || 500);
    const MIN_WORDS = Number(field.dataset.minWords || 10);

    let editor = form.querySelector(".problem-description-editor");
    let toolbar = form.querySelector(".problem-description-toolbar");
    let counter = document.getElementById("problemDescriptionCount");

    // Create an editor only if Blade does not already provide one.
    if (!editor) {
        const shell = document.createElement("div");
        shell.className = "problem-description-editor-wrapper";

        toolbar = document.createElement("div");
        toolbar.className = "problem-description-toolbar";

        editor = document.createElement("div");
        editor.className = "problem-description-editor";
        editor.contentEditable = "true";

        editor.setAttribute("role", "textbox");
        editor.setAttribute("aria-multiline", "true");
        editor.setAttribute(
            "data-placeholder",
            field.getAttribute("placeholder") || "Describe the problem...",
        );

        shell.append(toolbar, editor);
        field.insertAdjacentElement("beforebegin", shell);

        const commands = [
            ["bold", "Bold", "fas fa-bold"],
            ["italic", "Italic", "fas fa-italic"],
            ["underline", "Underline", "fas fa-underline"],
            ["insertUnorderedList", "Bullet list", "fas fa-list-ul"],
            ["insertOrderedList", "Numbered list", "fas fa-list-ol"],
            ["justifyLeft", "Align left", "fas fa-align-left"],
            ["justifyCenter", "Align center", "fas fa-align-center"],
            ["justifyRight", "Align right", "fas fa-align-right"],
        ];

        commands.forEach(function ([command, title, iconClass]) {
            const button = document.createElement("button");

            button.type = "button";
            button.className = "problem-toolbar-btn";
            button.title = title;
            button.setAttribute("aria-label", title);
            button.dataset.command = command;
            button.innerHTML = '<i class="' + iconClass + '"></i>';

            toolbar.appendChild(button);
        });
    }

    // Reuse the existing counter if Blade already contains one.
    if (!counter) {
        counter = document.createElement("div");
        counter.id = "problemDescriptionCount";
        counter.className = "problem-description-counter";

        editor.insertAdjacentElement("afterend", counter);
    }

    // Keep the original textarea as the Laravel form field.
    field.style.display = "none";
    field.classList.add("problem-description-hidden");

    function getPlainText() {
        return (editor.innerText || editor.textContent || "")
            .replace(/\u00a0/g, " ")
            .trim();
    }

    function countWords(text) {
        const matches = text.match(/[\p{L}\p{N}]+(?:['’-][\p{L}\p{N}]+)*/gu);

        return matches ? matches.length : 0;
    }

    function containsUrl(text) {
        return /(?:https?:\/\/|www\.|[a-z0-9-]+\.(?:com|net|org|io|co|edu|gov|info|dev|app)\b)/i.test(
            text,
        );
    }

    function cleanEditor() {
        editor
            .querySelectorAll(
                "a, iframe, object, embed, img, video, audio, script, style",
            )
            .forEach(function (node) {
                if (node.tagName === "A") {
                    node.replaceWith(
                        document.createTextNode(node.textContent || ""),
                    );
                } else {
                    node.remove();
                }
            });

        editor.querySelectorAll("*").forEach(function (node) {
            Array.from(node.attributes).forEach(function (attribute) {
                if (attribute.name.toLowerCase() !== "style") {
                    node.removeAttribute(attribute.name);
                }
            });

            const style = node.getAttribute("style") || "";

            const safeStyle = style
                .split(";")
                .filter(function (rule) {
                    return /^(text-align)\s*:\s*(left|center|right|justify)\s*$/i.test(
                        rule.trim(),
                    );
                })
                .join(";");

            if (safeStyle) {
                node.setAttribute("style", safeStyle);
            } else {
                node.removeAttribute("style");
            }
        });
    }

    function syncContent() {
        cleanEditor();

        let text = getPlainText();
        let words = countWords(text);

        if (words > MAX_WORDS) {
            // Preserve the word limit if the user pastes long content.
            const tokens =
                text.match(/[\p{L}\p{N}]+(?:['’-][\p{L}\p{N}]+)*/gu) || [];

            editor.textContent = tokens.slice(0, MAX_WORDS).join(" ");

            text = getPlainText();
            words = countWords(text);
        }

        field.value = editor.innerHTML;

        counter.textContent = words + " / " + MAX_WORDS + " words";

        counter.classList.toggle("is-over-limit", words > MAX_WORDS);

        counter.classList.toggle(
            "is-under-minimum",
            words > 0 && words < MIN_WORDS,
        );

        return words;
    }

    // Toolbar actions.
    if (toolbar) {
        toolbar.querySelectorAll("button").forEach(function (button) {
            if (button.dataset.descriptionBound === "true") return;

            button.dataset.descriptionBound = "true";

            button.addEventListener("mousedown", function (event) {
                event.preventDefault();
            });

            button.addEventListener("click", function () {
                const command = button.dataset.command;

                if (!command) return;

                editor.focus();

                document.execCommand(command, false, null);

                syncContent();
            });
        });
    }

    // Editor changes.
    editor.addEventListener("input", function () {
        syncContent();
    });

    // Block unsafe URL pasting.
    editor.addEventListener("paste", function (event) {
        event.preventDefault();

        const clipboard = event.clipboardData || window.clipboardData;
        const text = clipboard ? clipboard.getData("text/plain") : "";

        if (containsUrl(text)) {
            counter.textContent = "Links are not allowed in the description.";
            counter.classList.add("is-over-limit");
            return;
        }

        document.execCommand("insertText", false, text);
        syncContent();
    });

    // Block URL drops.
    editor.addEventListener("drop", function (event) {
        event.preventDefault();

        const text = event.dataTransfer
            ? event.dataTransfer.getData("text/plain")
            : "";

        if (containsUrl(text)) {
            counter.textContent = "Links are not allowed in the description.";
            counter.classList.add("is-over-limit");
            return;
        }

        editor.focus();
        document.execCommand("insertText", false, text);
        syncContent();
    });

    // Remove typed URLs when a word is completed.
    editor.addEventListener("keyup", function (event) {
        if (event.key !== " " && event.key !== "Enter") {
            return;
        }

        const text = getPlainText();

        if (!containsUrl(text)) return;

        const cleanedText = text.replace(
            /(?:https?:\/\/\S+|www\.\S+|\b[\w-]+\.(?:com|net|org|io|co|edu|gov|info|dev|app)\S*)/gi,
            "[link removed]",
        );

        editor.textContent = cleanedText;
        syncContent();

        counter.textContent = "Links are not allowed in the description.";
    });

    // Validate description before AJAX submission.
    form.addEventListener("submit", function (event) {
        const words = syncContent();

        if (words < MIN_WORDS) {
            event.preventDefault();

            form.dataset.descriptionInvalid = "true";

            counter.textContent =
                "Please enter at least " + MIN_WORDS + " words.";

            counter.classList.add("is-under-minimum");

            editor.focus();
            return;
        }

        if (words > MAX_WORDS) {
            event.preventDefault();

            form.dataset.descriptionInvalid = "true";

            counter.textContent = "Maximum " + MAX_WORDS + " words allowed.";

            counter.classList.add("is-over-limit");

            editor.focus();
            return;
        }

        form.dataset.descriptionInvalid = "false";
    });

    // Prevent AJAX submission if the description failed validation.
    form.addEventListener("submit", function (event) {
        if (form.dataset.descriptionInvalid === "true") {
            event.preventDefault();
        }
    });

    // Reset editor after successful report submission.
    form.addEventListener("problemReport:success", function () {
        editor.innerHTML = "";
        field.value = "";

        counter.textContent = "0 / " + MAX_WORDS + " words";
        counter.classList.remove("is-over-limit", "is-under-minimum");

        form.dataset.descriptionInvalid = "false";
    });

    // Restore initial content if present.
    if (field.value.trim()) {
        editor.innerHTML = field.value;
        cleanEditor();
    }

    syncContent();
});
