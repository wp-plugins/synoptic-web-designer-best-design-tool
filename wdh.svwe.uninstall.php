<?php

/*
* Title                   : Synoptic Web Designer: best WordPress design tool Light
* Version                 : 1.0
* File                    : wdh.svwe.uninstall.php
* File Version            : 1.0
* Created / Last Modified : 30 March 2014
* Author                  : Web Developers House
* Copyright               : © 2013 WDH.IM
* Website                 : http://www.wdh.im
* Description             : Synoptic Live Webdesign Editor - Wordpress Plugin Uninstallation File.
*/
    
    function wdhsvweUninstall() {
        // Delete Database
        wdhsvweDeleteDatabase();
        // Delete Options
        wdhsvweDeleteOptions();
    }

    function wdhsvweDeleteDatabase() {
        global $wpdb;

        $tables = $wpdb->get_results('SHOW TABLES');

        foreach ($tables as $table){
            $tableName = 'Tables_in_'.DB_NAME;
            $table_name = $table->$tableName;

            if (strrpos($table_name, 'wdh_svwe_') !== false){
                $wpdb->query("DROP TABLE IF EXISTS $table_name");
            }
        }
    }

    function wdhsvweDeleteOptions() {
        // Delete Options
        delete_option('WDH_SVWE_db_version');
        delete_option('WDH_SVWE_language');
        delete_option('WDH_SVWE_role');
        delete_option('WDH_SVWE_last_id_105');
    }


?>