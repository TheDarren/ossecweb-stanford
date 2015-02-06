<?php

# Array of admins listed by sunetid - this assumes webauth is in use.
$admins = [ 'darrenp1', 'jmcdermo', 'atayts' ];

# Timeout in min to flush the user and server cache.
$cache_timeout = 240;

# Enable debugging (if set to 1) - only useful for cli debugging.
$debug = 0;

# Path to the ticket cache. This should be maintained by a k5start job.
$k5_ticket_cache='/var/tmp/service.crcweb';

# Path to the slite db.
$db_path = 'db/ossec.db';

?>
