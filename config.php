<?php
// ============================================================
//  CastoPOST - Configuracion
// ============================================================

// Contrasena de acceso a esta aplicacion
define('APP_PASSWORD', 'mi_contrasena_segura');

// URL de tu instancia de Castopod (sin barra final)
define('CASTOPOD_URL', 'https://tu-castopod.com');

// Credenciales REST API (del .env de Castopod)
define('CASTOPOD_API_USER',     'tu_usuario_api');
define('CASTOPOD_API_PASSWORD', 'tu_password_api');

// Handle del podcast principal (el del config.php actua como default)
// Los demas podcasts se gestionan desde el panel
define('CASTOPOD_PODCAST_HANDLE', 'my-podcast');

// ID de tu usuario en Castopod (Admin -> Usuarios -> editar -> numero en la URL)
define('CASTOPOD_USER_ID', 1);

// Archivo JSON donde se guardan los podcasts adicionales (persistente)
define('PODCASTS_FILE',   __DIR__ . '/podcasts.json');

// Archivo JSON para borradores locales de episodios
define('DRAFTS_FILE',     __DIR__ . '/local_drafts.json');

// Archivo JSON para plantillas de descripcion
define('TEMPLATES_FILE',  __DIR__ . '/templates.json');

// Directorio temporal para uploads y conversiones
define('UPLOAD_TMP_DIR', __DIR__ . '/tmp');

// Tamano maximo de audio en bytes (500 MB)
define('MAX_AUDIO_SIZE', 500 * 1024 * 1024);

// Zona horaria
date_default_timezone_set('UTC'); // Cambia a tu zona horaria: https://www.php.net/manual/en/timezones.php

// Debug: muestra respuestas raw de la API en pantalla y error_log
define('CASTOPOD_DEBUG', false);
// ============================================================
