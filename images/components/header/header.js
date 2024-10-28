document.addEventListener('DOMContentLoaded', function () {
    console.log('Header JS loaded successfully.');

    const mobileMenu = document.querySelector('.bsc__header--mobile');
    if (mobileMenu) {
        mobileMenu.addEventListener('click', function () {
            alert('Mobile header clicked!');
        });
    }
});