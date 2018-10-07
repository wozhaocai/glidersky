#!/bin/sh
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaHkPriceModel -aurdgt -n2
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaHkPriceModel -aurdgt -n3
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaHkPriceModel -asraug -n5
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaHkPriceModel -asraul -n5

/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaShPriceModel -aurdgt -n2
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaShPriceModel -aurdgt -n3
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaShPriceModel -asraug -n5
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaShPriceModel -asraul -n5

/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaSzPriceModel -aurdgt -n2
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaSzPriceModel -aurdgt -n3
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaSzPriceModel -asraug -n5
/usr/bin/php /home/data/wwwroot/glidersky/test/job.php -btest\\model\\ChinaSzPriceModel -asraul -n5

;;16 1 * * * /usr/bin/sh /home/data/wwwroot/glidersky/test/run.sh > /dev/null 2>&1 &