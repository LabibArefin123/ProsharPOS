document.addEventListener('DOMContentLoaded', function () {

    const allCheckboxes = document.querySelectorAll('.perm-all');

    const selectedCount = document.getElementById('selectedCount');

    const selectedWrapper = document.getElementById('selectedPermissionsWrapper');

    // UPDATE UI

    function updateSelectedPermissions() {

        const checked = document.querySelectorAll('.perm-all:checked');

        selectedCount.innerText = checked.length;

        selectedWrapper.innerHTML = '';

        checked.forEach(cb => {

            const badge = document.createElement('div');

            badge.classList.add('permission-badge');

            badge.innerHTML = `
                ${cb.dataset.name}
                <i class="fas fa-times"></i>
            `;

            badge.addEventListener('click', function () {

                cb.checked = false;

                updateSelectedPermissions();

                cb.closest('.permission-card')
                  .scrollIntoView({
                      behavior: 'smooth',
                      block: 'center'
                  });

                cb.closest('.permission-card-inner')
                  .classList.add('border-danger');

                setTimeout(() => {

                    cb.closest('.permission-card-inner')
                      .classList.remove('border-danger');

                }, 1200);

            });

            selectedWrapper.appendChild(badge);

        });
    }

    // CHECKBOX CHANGE

    allCheckboxes.forEach(cb => {

        cb.addEventListener('change', updateSelectedPermissions);

    });

    // GLOBAL SELECT ALL

    document.getElementById('selectAllPermissions')
        .addEventListener('click', function () {

            allCheckboxes.forEach(cb => cb.checked = true);

            updateSelectedPermissions();

        });

    // GLOBAL CLEAR

    document.getElementById('unselectAllPermissions')
        .addEventListener('click', function () {

            allCheckboxes.forEach(cb => cb.checked = false);

            updateSelectedPermissions();

        });

    // GROUP SELECT

    document.querySelectorAll('.select-group-btn')
        .forEach(btn => {

            btn.addEventListener('click', function () {

                const group = this.dataset.group;

                document.querySelectorAll(`.perm-${group}`)
                    .forEach(cb => cb.checked = true);

                updateSelectedPermissions();

            });

        });

    // GROUP CLEAR

    document.querySelectorAll('.unselect-group-btn')
        .forEach(btn => {

            btn.addEventListener('click', function () {

                const group = this.dataset.group;

                document.querySelectorAll(`.perm-${group}`)
                    .forEach(cb => cb.checked = false);

                updateSelectedPermissions();

            });

        });

    updateSelectedPermissions();

});