<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">💈 <?php echo $nome_barbearia; ?></a>
        <div class="d-flex align-items-center gap-3">
            <span class="navbar-text text-white">
                <?php echo saudar(); ?>! | Tel: <?php echo $contato; ?>
            </span>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="themeSwitch" aria-label="Alternar tema">
                <label class="form-check-label text-white" for="themeSwitch"><span id="themeIcon">🌙</span></label>
            </div>
        </div>
    </div>
</nav>
<script>
(function () {
    const root = document.documentElement;
    const input = document.getElementById('themeSwitch');
    const icon = document.getElementById('themeIcon');

    function aplicar(tema) {
        root.setAttribute('data-bs-theme', tema);
        input.checked = tema === 'dark';
        icon.textContent = tema === 'dark' ? 'Claro' : 'Escuro';
        localStorage.setItem('tema', tema);
    }

    aplicar(localStorage.getItem('tema') || 'light');

    input.addEventListener('change', function () {
        aplicar(this.checked ? 'dark' : 'light');
    });
})();
</script>

