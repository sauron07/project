<?php
group('db', function(){

    desc('Create DB');
    task('createDB', function(){
        $config = require 'config/autoload/doctrine.local.php';
        $config = $config['doctrine']['connection']['orm_default']['params'];
        $connect = mysql_connect($config['host'], $config['user'], $config['password']);
        $sql = 'CREATE DATABASE home CHARACTER SET utf8 COLLATE utf8_general_ci';
        mysql_query($sql, $connect);
        mysql_close($connect);
    });

    desc('Create sql schema.');
    task('create', function(){
        $result = exec(sprintf('php ./vendor/bin/doctrine-module orm:schema-tool:create'));
        printf("%s\n", $result);
    });

    desc('Drop tables.');
    task('drop', function(){
        $result = exec(sprintf('php ./vendor/bin/doctrine-module orm:schema-tool:drop --force'));
        printf("%s\n", $result);
    });

    desc('Update sql schema.');
    task('update', function(){
        $result = exec(sprintf('php ./vendor/bin/doctrine-module orm:schema-tool:update --force'));
        printf("%s\n", $result);
    });

    desc('Load fixtures');
    task('fixture', function(){
        exec(sprintf('php ./vendor/bin/doctrine-module data-fixture:import'));
        printf("Fixtures loaded.\n");
    });

    desc('Clear DB and regenerate fixtures');
    task('clear', 'db:drop', 'db:create', 'db:fixture', function(){
        printf("Clear successfully! \n");
    });
});


group('cache', function(){

    desc('Clear doctrine metadata cache');
    task('metadata', function(){
        exec(sprintf('php ./vendor/bin/doctrine-module orm:clear-cache:metadata'));
        printf("Metadata cache cleared!\n");
    });

    desc('Clear doctrine query cache');
    task('query', function(){
        exec(sprintf('php ./vendor/bin/doctrine-module orm:clear-cache:query'));
        printf("Query cache cleared!\n");
    });

    desc('Clear doctrine result cache');
    task('result', function(){
        exec(sprintf('php ./vendor/bin/doctrine-module orm:clear-cache:result'));
        printf("Result cache cleared!\n");
    });

    task('clear', 'cache:metadata', 'cache:query', 'cache:result', function(){
        printf("All doctrine cache is cleared!\n");
    });
});