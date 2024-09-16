<?php

//turn on error reporting
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// unlimited input vars
// ini_set('max_input_vars', -1);
// ini_set('max_input_nesting_level', -1);
// // unlimited execution time
// ini_set('max_execution_time', 0);
// // unlimited memory
// ini_set('memory_limit', '-1');
// // unlimited post size
// ini_set('post_max_size', '-1');

//phpinfo();

//exit;

// create adminer object with plugins
function adminer_object()
{
    // required to run any plugin
    include_once __DIR__ . "/plugins/plugin.php";

    // autoloader
    foreach (glob(__DIR__ . "/plugins/*.php") as $filename) {
        include_once "$filename";
    }

    if(isset($_GET['sqlite'])) {

        $plugins = [

            new AdminerTablesFilter(),
            new AdminerFrames(),
            new AdminerDumpAlter(),
            new AdminerDumpJson(),
            new AdminerJsonColumn(),
            new AdminerLoginPasswordLess(password_hash(config('database.connections.company.password'), PASSWORD_DEFAULT)),
        ];

        return new AdminerPlugin($plugins);
    }

    $plugins = [
        // specify enabled plugins here
        // new AdminerDumpXml,
        // new AdminerTinymce,
        // new AdminerFileUpload("data/"),
        // new AdminerSlugify,
        // new AdminerTranslation,
        // new AdminerForeignSystem,
        // new AdminerDesigns;
        new AdminerTablesFilter(),
        new AdminerFrames(),
        new AdminerDumpAlter(),
        new AdminerDumpJson(),
        new AdminerJsonColumn(),
        // new AdminerSqlLog(),
        new AdminerTheme('default-blue'),
    ];

    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    class AdminerSoftware extends AdminerPlugin
    {
        public function login($login, $password)
        {
            return true;
        }

        public function credentials()
        {
            // die('here');
            // server, username and password for connecting to database
            // if(isset($_GET['pgsql'])) {
            //     return array('127.0.0.1', 'laravel', '');
            // }
            return array('127.0.0.1', 'root', '');
        }

        public function name()
        {
            // custom name in title and heading
            return 'MYSQL';
        }

    }

    return new AdminerSoftware($plugins);
}
include __DIR__ . "/adminer-4.8.1.php";
