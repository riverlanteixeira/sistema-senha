<div class="container">
    <div class="navigation-menu">
        <a href="/senha/admin/" class="nav-button <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/') !== false) ? 'active' : ''; ?>">Administração</a>
        <a href="/senha/operador/" class="nav-button <?php echo (strpos($_SERVER['REQUEST_URI'], '/operador/') !== false) ? 'active' : ''; ?>">Operadores</a>
        <a href="/senha/painel/" class="nav-button <?php echo (strpos($_SERVER['REQUEST_URI'], '/painel/') !== false) ? 'active' : ''; ?>">Painel</a>
    </div>
</div>