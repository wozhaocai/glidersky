#!/bin/sh
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\model\UsChinaPriceModel -aurdgt -n2
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\model\UsChinaPriceModel -aurdgt -n3
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\model\UsChinaPriceModel -asraug -n5
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\model\UsChinaPriceModel -asraul -n5

;;16 1 * * * /usr/bin/sh /home/data/wwwroot/glidersky/test/run.sh > /dev/null 2>&1 &