 -------------------
| IMPORT DATA SQL   |
 -------------------

LOAD DATA LOCAL INFILE 'C:\\WORK\\google-packages\\files\\Packagenames.csv'
INTO TABLE `google-packages`
FIELDS TERMINATED BY ','
ENCLOSED BY '"'

 --------------
| RDS DATABASE |
 --------------
google-packages.cixjbteelrgv.us-east-1.rds.amazonaws.com
peter - gramercy

 -------------------
| AMAZON PHP SERVER |
 -------------------
ec2-user@54.172.208.134
ppk key is in `amazon` folder


 ---------------
| RUN ALL TASKS |
 ---------------
/usr/bin/php /home/ec2-user/google-packages/runner.php

-------------------------------------------------
| RUN SINGLE TASK WIH PARAMS - OUTPUT TO CONSOLE |
-------------------------------------------------

/usr/bin/php /home/ec2-user/google-packages/parseparams.php  0 1000

----------------------------------------------
| RUN SINGLE TASK WIH PARAMS - OUTPUT TO FILE |
----------------------------------------------
/usr/bin/php /home/ec2-user/google-packages/parseparams.php  0 1000 >data_0000_1000.csv &

----------------------------------------------
| RUN SINGLE FILE FIX - OUTPUT TO FILE |
----------------------------------------------
nohup /usr/bin/php /home/ec2-user/google-packages/parsefile.php  /home/ec2-user/google-packages/VariesWithDevice1.csv >/home/ec2-user/google-packages/fixes/data_VariesWithDevice1.csv &
nohup /usr/bin/php /home/ec2-user/google-packages/parsefile.php  /home/ec2-user/google-packages/VariesWithDevice2.csv >/home/ec2-user/google-packages/fixes/data_VariesWithDevice2.csv &
nohup /usr/bin/php /home/ec2-user/google-packages/parsefile.php  /home/ec2-user/google-packages/VariesWithDevice3.csv >/home/ec2-user/google-packages/fixes/data_VariesWithDevice3.csv &

---------------------------------------------
SEE PROCESSES
pgrep -l -u ec2-user
---------------------------------------------

KILL ALL PHP TASKS
pkill -9 php

---------------------------------------------

COUNT FILES
ls -l | grep ^- | wc -l

---------------------------------------------

CONCAT FILES
cat /home/ec2-user/google-packages/logs/*csv > "/home/ec2-user/google-packages/google-packages-$(date +"%d%m%Y_%H%M%S").csv"



