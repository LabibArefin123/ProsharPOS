/* Entry point: initialize the Problem Report attachment uploader */
document.addEventListener("DOMContentLoaded", function () {
    const PU = window.ProblemUpload;
    PU.form = document.getElementById("problemReportForm");
    PU.input = document.getElementById("problem_attachments");
    PU.uploadZone = document.querySelector(".problem-upload-zone");

    if (!PU.form || !PU.input || !PU.uploadZone) return;

    PU.preview = document.getElementById("problemFilePreview");
    PU.fileCount = document.getElementById("problemFileCount");
    PU.progressSection = document.getElementById("problemProgressSection");
    PU.progressBar = document.getElementById("problemProgressBar");
    PU.progressPercent = document.getElementById("problemProgressPercent");
    PU.progressStatus = document.getElementById("problemProgressStatus");
    PU.progressSize = document.getElementById("problemProgressSize");
    PU.progressList = document.getElementById("problemProgressList");
    PU.submitButton = document.getElementById("problemSubmitButton");
    PU.formMessage = document.getElementById("problemFormMessage");
    PU.selectedFiles = [];

    PU.bindFileSelection();
    PU.submitForm();
    PU.resetProgress();
    PU.renderPreview();
});
