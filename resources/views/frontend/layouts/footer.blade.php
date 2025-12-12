<footer class="main-footer d-flex justify-content-between align-items-center px-4 py-3 bg-light shadow-sm">
    <div>
        © {{ date('Y') }} <a href="#" target="_blank" class="dev-link fw-bold text-decoration-none">
            <strong>ProsharPOS</strong>
        </a> All rights reserved.
    </div>
    <div>
        Design and Developed by
        <a href="https://labib.work" target="_blank" class="dev-link fw-bold text-decoration-none ms-1">
            <span class="custom-name">
                Labib Arefin
            </span>
        </a>
    </div>
</footer>

<style>
    .dev-link {
        padding: 1px 1px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        color: #000;
    }

    .dev-link:hover {
        background-color: #0d53a9;
        color: #fff;
    }

    .custom-name {
        font-family: "OnStage", sans-serif;
        font-weight: normal;
        margin-left: 5px;
    }

    .custom-name .total {
        color: #ff9900;
        font-size: 18fr;
    }

    .custom-name .offtec {
        color: #d9d9d9;
        font-size: 18px;
        margin-left: 1px;
    }

    @font-face {
        font-family: "OnStage";
        src: url("{{ asset('assets/frontend/fonts/Onstage_regular.ttf') }}") format("truetype");
        font-weight: normal;
        font-style: normal;
    }
</style>
