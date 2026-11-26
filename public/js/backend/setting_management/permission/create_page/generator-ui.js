document.addEventListener("DOMContentLoaded", function () {
    const style = document.createElement("style");

    style.innerHTML = `

    .permission-generator-card {
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 35px rgba(0,0,0,0.06);
    }

    .permission-input {
        height:56px;
        border-radius:16px;
        font-size:15px;
        padding-left:18px;
    }

    .permission-counter-badge {
        background:#0d6efd;
        color:#fff;
        padding:10px 18px;
        border-radius:40px;
        font-size:14px;
        font-weight:700;
    }

    .generated-permission-list {
        display:flex;
        flex-direction:column;
        gap:14px;
        max-height:500px;
        overflow-y:auto;
    }

    .generated-permission-item {
        cursor:pointer;
        margin:0;
    }

    .generated-permission-item input {
        display:none;
    }

    .generated-permission-content {
        display:flex;
        align-items:center;
        gap:16px;
        padding:18px;
        border-radius:18px;
        border:1px solid #e5e7eb;
        transition:0.25s ease;
    }

    .generated-permission-content:hover {
        border-color:#0d6efd;
    }

    .generated-circle {
        width:22px;
        height:22px;
        border-radius:50%;
        border:2px solid #ced4da;
        flex-shrink:0;
        transition:0.25s ease;
    }

    .generated-permission-item input:checked
    + .generated-permission-content {
        border-color:#0d6efd;
        background:rgba(13,110,253,0.06);
    }

    .generated-permission-item input:checked
    + .generated-permission-content .generated-circle {
        background:#0d6efd;
        border-color:#0d6efd;
    }

    .selected-permission-wrapper {
        display:flex;
        flex-wrap:wrap;
        gap:12px;
    }

    .selected-permission-badge {
        background:#0d6efd;
        color:#fff;
        padding:12px 18px;
        border-radius:50px;
        display:flex;
        align-items:center;
        gap:10px;
        font-size:13px;
        transition:0.25s ease;
    }

    .selected-permission-badge:hover {
        background:#0b5ed7;
    }

    .remove-permission {
        cursor:pointer;
    }

    .permission-modal-content {
        border:none;
        border-radius:24px;
    }

    .save-final-btn {
        border-radius:14px;
        padding:13px 26px;
        font-weight:700;
    }

    `;

    document.head.appendChild(style);
});
