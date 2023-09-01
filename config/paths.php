<?php

define('isProduction', false);
if (isProduction) {
    define('URL', 'https://calienteitech.in/Securelist_Admin/');
    define('server_root', $_SERVER['DOCUMENT_ROOT']."/Securelist_Admin");
} else {
    define('URL', 'http://localhost/Securelist_Admin/');
    define('server_root', $_SERVER['DOCUMENT_ROOT']."/Securelist_Admin");
}

define('admin_link', 'admin');
define('api_url', 'https://api.securlists.com/api');
define("ciphering", "AES-128-CTR");
define("options", 0);
define("encryption_iv", "1234567891011121");
define("decryption_iv", "1234567891011121");
define("encryption_key", "GeeksforGeeks");
define("decryption_key", "GeeksforGeeks");
