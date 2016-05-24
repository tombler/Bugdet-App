<?php

    echo "Starting Behat tests...\n\n";
    echo shell_exec("bin/behat features/variousartists.feature");
    echo "Done.\n";

?>
