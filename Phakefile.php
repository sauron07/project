<?php
group('db', function(){
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

