document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(
        ".navbar-search-block input.form-control-navbar",
    );

    if (!searchInput) return;

    // Result dropdown
    const resultBox = document.createElement("div");
    resultBox.style.position = "absolute";
    resultBox.style.top = "40px";
    resultBox.style.left = "0";
    resultBox.style.width = "100%";
    resultBox.style.maxHeight = "250px";
    resultBox.style.overflowY = "auto";
    resultBox.style.background = "#ffffff";
    resultBox.style.border = "1px solid #ddd";
    resultBox.style.borderRadius = "6px";
    resultBox.style.boxShadow = "0 4px 8px rgba(0,0,0,0.08)";
    resultBox.style.zIndex = "99999";
    resultBox.style.display = "none";
    resultBox.style.color = "#000";

    const parentGroup = searchInput.closest(".input-group");
    parentGroup.style.position = "relative";
    parentGroup.appendChild(resultBox);

    let timer = null;

    searchInput.addEventListener("keyup", function () {
        const query = this.value.trim();
        clearTimeout(timer);

        if (query.length < 2) {
            resultBox.style.display = "none";
            return;
        }

        timer = setTimeout(() => {
            fetch(
                `/notifications/search?adminlteSearch=${encodeURIComponent(query)}`,
            )
                .then((r) => r.json())
                .then((data) => {
                    if (!Array.isArray(data) || data.length === 0) {
                        resultBox.innerHTML = `
                            <div class="p-2 text-muted" style="color:#555;">No results found</div>`;
                    } else {
                        resultBox.innerHTML = data
                            .map(
                                (v) => `
                            <div class="search-item"
                                style="
                                    padding:8px 12px;
                                    cursor:pointer;
                                    display:flex;
                                    justify-content:space-between;
                                    align-items:center;
                                    border-bottom:1px solid #f1f1f1;
                                    color:#000;
                                "
                                onmouseover="this.style.background='#f7f7f7'"
                                onmouseout="this.style.background='#fff'"
                                onclick="window.location='/${v.type}/${v.id}'">
                                
                                <span style="font-size:14px; font-weight:500;">
                                    ${v.name}
                                </span>

                                <span style="
                                    font-size:11px;
                                    background:#e6f0ff;
                                    color:#000;
                                    padding:2px 6px;
                                    border-radius:4px;
                                ">
                                    ${v.type.toUpperCase()}
                                </span>
                            </div>
                        `,
                            )
                            .join("");
                    }
                    resultBox.style.display = "block";
                });
        }, 300);
    });

    // Close when clicking outside
    document.addEventListener("click", function (e) {
        if (!resultBox.contains(e.target) && e.target !== searchInput) {
            resultBox.style.display = "none";
        }
    });
});
