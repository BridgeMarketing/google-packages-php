LOAD DATA LOCAL INFILE 'C:\\WORK\\google-packages\\files\\Packagenames.csv'
INTO TABLE `google-packages`
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'

----
see processes
pgrep -l -u bridgedev
---

kil all php
pkill -9 php
----

see log
tail -f /home/bridgedev/google-packages/data.log

----

count files
ls -l | grep ^- | wc -l


---------

concat files

cat /home/bridgedev/google-packages/logs/*csv > /home/bridgedev/google-packages/google-packages1.csv

-------

10.0.3.61
bridgedev
On3Br!dge185!
----------
RUN ALL TASK

/usr/bin/php /home/bridgedev/google-packages/runner.php

-----------
RUN TASK WIH PARAMS
/usr/bin/php /home/bridgedev/google-packages/parseparams.php 6000 7000 >data_6000_7000.log &

