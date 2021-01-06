<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'dima246_246' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'dima246_246' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '8IjPmh*v' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':5.WtP-ym}K k@sqd3V9>YT#?47dnvdo-VjGpb9U>pUwS{&~H[cx/gB1vD.#&,cf');
define('SECURE_AUTH_KEY',  '+QznzN<{!3npWYKx5HIq$2ZT$|@xFsFn>?Nh@rzXc])a}L-Q84@w!k7QxXyoTH]N');
define('LOGGED_IN_KEY',    '#lg|JWS-n1@r+vdv|t^.>-?%=Chtk@|ej`t+6t(e`Kcl|=i~c(0z(+z-b-3g/T4o');
define('NONCE_KEY',        'Mzs*9~+g9<,L<OVUM(mi1G<JzM k[=sS%bo[E/*m5Lz^R::>s)2uHp_!)lxQPiys');
define('AUTH_SALT',        'x*O5r`7JG~:>SLM;`#~G-ady(c*A/-Z%!-D|=]YM(0+Zhb&:Up)H/7|9fD+v|p}z');
define('SECURE_AUTH_SALT', 'Vu-:eD?b{?ITq?iGN+t,uqOB!:vL7||p|1-,:r/OC_/GlN4fUTC,>+$g ~>283ba');
define('LOGGED_IN_SALT',   '>Sy)}(&PD}]s4V3$P%-+r;~O/u+YQbJHl*F6w|~S%@8<Y_kFrPNPn$*e^ihr$rf,');
define('NONCE_SALT',       'Zdjq<oYz! Bbf;Ac/3ikOqWE6mT99Xg={+ Xg_7jsj|ls>8+-*OhhGb4&kwxT&S+');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
