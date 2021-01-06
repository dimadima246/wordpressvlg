<?php

// Проверили авторизацию
if(!isAuth() || !isInstalled()) redirect(WP_ADMIN_URL);

uninstall();

echo 'uninstalled';