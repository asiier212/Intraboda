DEBUG - 2025-03-05 10:25:28 --> Config Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:25:28 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:25:28 --> URI Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Router Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Output Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Security Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Input Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:25:28 --> Language Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Loader Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:25:28 --> Controller Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Session Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:25:28 --> Session routines successfully run
DEBUG - 2025-03-05 10:25:28 --> Model Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Model Class Initialized
DEBUG - 2025-03-05 10:25:28 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:25:28 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:25:28 --> Respuestas recibidas: Array
(
    [10] => 5
    [11] => 5
    [12] => ¿Más de 150? — Prepárate. Esto ya es un festival encubierto y probablemente alguien acabará encima de las mesas. Dime... ¿cuántos seréis? 
    [13] => 2horas
    [14] => 1:30
    [41] => Array
        (
            [0] => Pachangueras
        )

    [42] => Array
        (
            [0] => Salsa
        )

)

DEBUG - 2025-03-05 10:25:28 --> Última consulta ejecutada: 
								INSERT INTO respuestas_encuesta_datos_boda (id_pregunta, id_cliente, respuesta) 
								VALUES (42, '1', 'Salsa')
DEBUG - 2025-03-05 10:25:28 --> Ejecutando consulta: SELECT id, nombre FROM servicios WHERE id IN (4,73)
DEBUG - 2025-03-05 10:25:28 --> File loaded: application/views/cliente/header.php
DEBUG - 2025-03-05 10:25:28 --> File loaded: application/views/cliente/cliente_details.php
DEBUG - 2025-03-05 10:25:28 --> File loaded: application/views/cliente/footer.php
DEBUG - 2025-03-05 10:25:28 --> Final output sent to browser
DEBUG - 2025-03-05 10:25:28 --> Total execution time: 0.1286
DEBUG - 2025-03-05 10:25:29 --> Config Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:25:29 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:25:29 --> URI Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Router Class Initialized
ERROR - 2025-03-05 10:25:29 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:25:29 --> Config Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:25:29 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:25:29 --> URI Class Initialized
DEBUG - 2025-03-05 10:25:29 --> Router Class Initialized
ERROR - 2025-03-05 10:25:29 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:26:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:26:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:26:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Router Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Output Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Security Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Input Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:26:57 --> Language Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Loader Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:26:57 --> Controller Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Session Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:26:57 --> Session routines successfully run
DEBUG - 2025-03-05 10:26:57 --> Model Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Model Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:26:57 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:26:57 --> Respuestas recibidas: Array
(
    [10] => 7
    [11] => 10
    [13] => 2horas
    [14] => 1:30
    [41] => Array
        (
            [0] => Pachangueras
        )

    [42] => Array
        (
            [0] => Salsa
        )

)

DEBUG - 2025-03-05 10:26:57 --> Última consulta ejecutada: 
								UPDATE respuestas_encuesta_datos_boda 
								SET respuesta = 'Salsa' 
								WHERE id_pregunta = 42 AND id_cliente = '1'
DEBUG - 2025-03-05 10:26:57 --> Ejecutando consulta: SELECT id, nombre FROM servicios WHERE id IN (4,73)
DEBUG - 2025-03-05 10:26:57 --> File loaded: application/views/cliente/header.php
DEBUG - 2025-03-05 10:26:57 --> File loaded: application/views/cliente/cliente_details.php
DEBUG - 2025-03-05 10:26:57 --> File loaded: application/views/cliente/footer.php
DEBUG - 2025-03-05 10:26:57 --> Final output sent to browser
DEBUG - 2025-03-05 10:26:57 --> Total execution time: 0.1910
DEBUG - 2025-03-05 10:26:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:26:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:26:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Router Class Initialized
ERROR - 2025-03-05 10:26:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:26:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:26:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:26:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:26:57 --> Router Class Initialized
ERROR - 2025-03-05 10:26:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:28:26 --> Config Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:28:26 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:28:26 --> URI Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Router Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Output Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Security Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Input Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:28:26 --> Language Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Loader Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:28:26 --> Controller Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Session Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:28:26 --> Session routines successfully run
DEBUG - 2025-03-05 10:28:26 --> Model Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Model Class Initialized
DEBUG - 2025-03-05 10:28:26 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:28:26 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:28:26 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:28:26 --> File loaded: application/views/admin/encuesta.php
DEBUG - 2025-03-05 10:28:26 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:28:26 --> Final output sent to browser
DEBUG - 2025-03-05 10:28:26 --> Total execution time: 0.0698
DEBUG - 2025-03-05 10:28:32 --> Config Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:28:32 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:28:32 --> URI Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Router Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Output Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Security Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Input Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:28:32 --> Language Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Loader Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:28:32 --> Controller Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Session Class Initialized
DEBUG - 2025-03-05 10:28:32 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:28:32 --> Session routines successfully run
ERROR - 2025-03-05 10:28:32 --> Severity: Warning  --> mysqli::mysqli(): php_network_getaddresses: getaddrinfo failed: Host desconocido.  C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 132
ERROR - 2025-03-05 10:28:32 --> Severity: Warning  --> mysqli::mysqli(): (HY000/2002): php_network_getaddresses: getaddrinfo failed: Host desconocido.  C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 132
ERROR - 2025-03-05 10:28:32 --> Severity: Warning  --> mysqli_query(): Couldn't fetch mysqli C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 114
ERROR - 2025-03-05 10:28:32 --> Severity: Warning  --> mysqli_fetch_assoc() expects parameter 1 to be mysqli_result, null given C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 116
ERROR - 2025-03-05 10:28:32 --> Severity: Notice  --> Undefined property: Tarifas::$post C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 121
ERROR - 2025-03-05 10:28:32 --> Severity: Notice  --> Undefined property: Tarifas::$post C:\xampp\htdocs\intraboda\application\controllers\tarifas.php 126
DEBUG - 2025-03-05 10:28:32 --> File loaded: application/views/admin/header.php
ERROR - 2025-03-05 10:28:32 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\intraboda\application\views\admin\tarifas.php 30
DEBUG - 2025-03-05 10:28:32 --> File loaded: application/views/admin/tarifas.php
DEBUG - 2025-03-05 10:28:32 --> Final output sent to browser
DEBUG - 2025-03-05 10:28:32 --> Total execution time: 0.1671
DEBUG - 2025-03-05 10:28:38 --> Config Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:28:38 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:28:38 --> URI Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Router Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Output Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Security Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Input Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:28:38 --> Language Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Loader Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:28:38 --> Controller Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Session Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:28:38 --> Session routines successfully run
DEBUG - 2025-03-05 10:28:38 --> Model Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Model Class Initialized
DEBUG - 2025-03-05 10:28:38 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:28:38 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:28:38 --> Encrypt Class Initialized
DEBUG - 2025-03-05 10:28:38 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:28:38 --> File loaded: application/views/admin/admin_eventos_view.php
DEBUG - 2025-03-05 10:28:38 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:28:38 --> Final output sent to browser
DEBUG - 2025-03-05 10:28:38 --> Total execution time: 0.0944
DEBUG - 2025-03-05 10:29:04 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:04 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:04 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Output Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Security Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Input Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:29:04 --> Language Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Loader Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:29:04 --> Controller Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Session Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:29:04 --> Session routines successfully run
DEBUG - 2025-03-05 10:29:04 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:29:04 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
ERROR - 2025-03-05 10:29:04 --> Severity: Notice  --> Undefined index: page C:\xampp\htdocs\intraboda\application\controllers\admin.php 1280
DEBUG - 2025-03-05 10:29:04 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:29:04 --> File loaded: application/views/admin/clientes_view.php
DEBUG - 2025-03-05 10:29:04 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:29:04 --> Final output sent to browser
DEBUG - 2025-03-05 10:29:04 --> Total execution time: 0.0876
DEBUG - 2025-03-05 10:29:04 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:04 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:04 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:04 --> Router Class Initialized
ERROR - 2025-03-05 10:29:05 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:05 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:05 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:05 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:05 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:05 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:05 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:05 --> UTF-8 Support Enabled
ERROR - 2025-03-05 10:29:05 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:05 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Router Class Initialized
ERROR - 2025-03-05 10:29:05 --> 404 Page Not Found --> uploads
ERROR - 2025-03-05 10:29:05 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:05 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:05 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:05 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:05 --> Router Class Initialized
ERROR - 2025-03-05 10:29:05 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:06 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:06 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:06 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Output Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Security Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Input Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:29:06 --> Language Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Loader Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:29:06 --> Controller Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Session Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:29:06 --> Session routines successfully run
DEBUG - 2025-03-05 10:29:06 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:29:06 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:29:06 --> Encrypt Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Encrypt class already loaded. Second attempt ignored.
DEBUG - 2025-03-05 10:29:06 --> File loaded: application/views/admin/header.php
ERROR - 2025-03-05 10:29:06 --> Severity: Notice  --> Undefined variable: preguntas_encuesta_datos_boda C:\xampp\htdocs\intraboda\application\views\admin\clientes_viewdetails.php 653
ERROR - 2025-03-05 10:29:06 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\intraboda\application\views\admin\clientes_viewdetails.php 653
DEBUG - 2025-03-05 10:29:06 --> File loaded: application/views/admin/clientes_viewdetails.php
DEBUG - 2025-03-05 10:29:06 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:29:06 --> Final output sent to browser
DEBUG - 2025-03-05 10:29:06 --> Total execution time: 0.1858
DEBUG - 2025-03-05 10:29:06 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:06 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:06 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:06 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:06 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:07 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:07 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:07 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:07 --> Router Class Initialized
ERROR - 2025-03-05 10:29:07 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Output Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Security Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Input Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:29:48 --> Language Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Loader Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:29:48 --> Controller Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Session Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:29:48 --> Session routines successfully run
DEBUG - 2025-03-05 10:29:48 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:29:48 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:29:48 --> File loaded: application/views/admin/header.php
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
ERROR - 2025-03-05 10:29:48 --> Severity: Notice  --> Undefined index: descuento C:\xampp\htdocs\intraboda\application\views\admin\clientes_add.php 353
DEBUG - 2025-03-05 10:29:48 --> File loaded: application/views/admin/clientes_add.php
DEBUG - 2025-03-05 10:29:48 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:29:48 --> Final output sent to browser
DEBUG - 2025-03-05 10:29:48 --> Total execution time: 0.1406
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:48 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:48 --> Router Class Initialized
ERROR - 2025-03-05 10:29:48 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:56 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:56 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:56 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:56 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Output Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Security Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Input Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:29:57 --> Language Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Loader Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:29:57 --> Controller Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Session Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:29:57 --> Session routines successfully run
DEBUG - 2025-03-05 10:29:57 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:29:57 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
ERROR - 2025-03-05 10:29:57 --> Severity: Notice  --> Undefined index: page C:\xampp\htdocs\intraboda\application\controllers\admin.php 1280
DEBUG - 2025-03-05 10:29:57 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:29:57 --> File loaded: application/views/admin/clientes_view.php
DEBUG - 2025-03-05 10:29:57 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:29:57 --> Final output sent to browser
DEBUG - 2025-03-05 10:29:57 --> Total execution time: 0.0884
DEBUG - 2025-03-05 10:29:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
ERROR - 2025-03-05 10:29:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
ERROR - 2025-03-05 10:29:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
ERROR - 2025-03-05 10:29:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:57 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:57 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:57 --> UTF-8 Support Enabled
ERROR - 2025-03-05 10:29:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:57 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:57 --> Router Class Initialized
ERROR - 2025-03-05 10:29:57 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:59 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:59 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:59 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Router Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Output Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Security Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Input Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:29:59 --> Language Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Loader Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:29:59 --> Controller Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Session Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:29:59 --> Session routines successfully run
DEBUG - 2025-03-05 10:29:59 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Model Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:29:59 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:29:59 --> Encrypt Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Encrypt class already loaded. Second attempt ignored.
DEBUG - 2025-03-05 10:29:59 --> File loaded: application/views/admin/header.php
ERROR - 2025-03-05 10:29:59 --> Severity: Notice  --> Undefined variable: preguntas_encuesta_datos_boda C:\xampp\htdocs\intraboda\application\views\admin\clientes_viewdetails.php 653
ERROR - 2025-03-05 10:29:59 --> Severity: Warning  --> Invalid argument supplied for foreach() C:\xampp\htdocs\intraboda\application\views\admin\clientes_viewdetails.php 653
DEBUG - 2025-03-05 10:29:59 --> File loaded: application/views/admin/clientes_viewdetails.php
DEBUG - 2025-03-05 10:29:59 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:29:59 --> Final output sent to browser
DEBUG - 2025-03-05 10:29:59 --> Total execution time: 0.1306
DEBUG - 2025-03-05 10:29:59 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:59 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:59 --> URI Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Router Class Initialized
ERROR - 2025-03-05 10:29:59 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:29:59 --> Config Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:29:59 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:29:59 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:29:59 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Hooks Class Initialized
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:00 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:00 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:00 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:00 --> UTF-8 Support Enabled
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:00 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:00 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:00 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:00 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:00 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:00 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:00 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:00 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:00 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:00 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:00 --> Router Class Initialized
ERROR - 2025-03-05 10:30:00 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:37 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:37 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:37 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Output Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Security Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Input Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:30:37 --> Language Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Loader Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:30:37 --> Controller Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Session Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:30:37 --> Session routines successfully run
DEBUG - 2025-03-05 10:30:37 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:37 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:30:37 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:30:37 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:30:37 --> File loaded: application/views/admin/servicios_view.php
DEBUG - 2025-03-05 10:30:37 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:30:37 --> Final output sent to browser
DEBUG - 2025-03-05 10:30:37 --> Total execution time: 0.0626
DEBUG - 2025-03-05 10:30:40 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:40 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:40 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Output Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Security Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Input Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:30:40 --> Language Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Loader Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:30:40 --> Controller Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Session Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:30:40 --> Session routines successfully run
DEBUG - 2025-03-05 10:30:40 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:40 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:30:40 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:30:40 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:30:40 --> File loaded: application/views/admin/mantenimiento_equipos.php
DEBUG - 2025-03-05 10:30:40 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:30:40 --> Final output sent to browser
DEBUG - 2025-03-05 10:30:40 --> Total execution time: 0.0778
DEBUG - 2025-03-05 10:30:42 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:42 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:42 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Output Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Security Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Input Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:30:42 --> Language Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Loader Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:30:42 --> Controller Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Session Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:30:42 --> Session routines successfully run
DEBUG - 2025-03-05 10:30:42 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:42 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:30:42 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:30:42 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:30:42 --> File loaded: application/views/admin/mantenimiento_equipos.php
DEBUG - 2025-03-05 10:30:42 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:30:42 --> Final output sent to browser
DEBUG - 2025-03-05 10:30:42 --> Total execution time: 0.0866
DEBUG - 2025-03-05 10:30:43 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:43 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:43 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Output Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Security Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Input Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:30:43 --> Language Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Loader Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:30:43 --> Controller Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Session Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:30:43 --> Session routines successfully run
DEBUG - 2025-03-05 10:30:43 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Model Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Database Driver Class Initialized
ERROR - 2025-03-05 10:30:43 --> Severity: 8192  --> mysql_pconnect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead C:\xampp\htdocs\intraboda\system\database\drivers\mysql\mysql_driver.php 88
DEBUG - 2025-03-05 10:30:43 --> File loaded: application/views/admin/header.php
DEBUG - 2025-03-05 10:30:43 --> File loaded: application/views/admin/oficinas.php
DEBUG - 2025-03-05 10:30:43 --> File loaded: application/views/admin/footer.php
DEBUG - 2025-03-05 10:30:43 --> Final output sent to browser
DEBUG - 2025-03-05 10:30:43 --> Total execution time: 0.0653
DEBUG - 2025-03-05 10:30:43 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:43 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:43 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Router Class Initialized
ERROR - 2025-03-05 10:30:43 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:43 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:43 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:43 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:43 --> Router Class Initialized
ERROR - 2025-03-05 10:30:43 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:43 --> Config Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:44 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:44 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Router Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Config Class Initialized
ERROR - 2025-03-05 10:30:44 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:30:44 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:30:44 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:30:44 --> URI Class Initialized
DEBUG - 2025-03-05 10:30:44 --> Router Class Initialized
ERROR - 2025-03-05 10:30:44 --> 404 Page Not Found --> uploads
DEBUG - 2025-03-05 10:47:47 --> Config Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Hooks Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Utf8 Class Initialized
DEBUG - 2025-03-05 10:47:47 --> UTF-8 Support Enabled
DEBUG - 2025-03-05 10:47:47 --> URI Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Router Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Output Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Security Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Input Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Global POST and COOKIE data sanitized
DEBUG - 2025-03-05 10:47:47 --> Language Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Loader Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Helper loaded: url_helper
DEBUG - 2025-03-05 10:47:47 --> Controller Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Session Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Helper loaded: string_helper
DEBUG - 2025-03-05 10:47:47 --> Session routines successfully run
DEBUG - 2025-03-05 10:47:47 --> Model Class Initialized
DEBUG - 2025-03-05 10:47:47 --> Model Class Initialized
DEBUG - 2025-03-05 10:47:47 --> File loaded: application/views/dj/login.php
DEBUG - 2025-03-05 10:47:47 --> Final output sent to browser
DEBUG - 2025-03-05 10:47:47 --> Total execution time: 0.1382
