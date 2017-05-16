create table `google-packages`.`google-packages`
(
	package mediumtext null,
	id int auto_increment
		primary key,
	updated_at datetime default CURRENT_TIMESTAMP null,
	url mediumtext null,
	downloads mediumtext null,
	category mediumtext null
)
;



create table `google-packages`
(
	package mediumtext null
)

ALTER TABLE `google-packages` ADD `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY

----
IMPORT DATA
----

LOAD DATA LOCAL INFILE 'C:\\WORK\\google-packages\\files\\Packagenames.csv'
INTO TABLE `google-packages`
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'



------
DATABASE

google-packages.cixjbteelrgv.us-east-1.rds.amazonaws.com
peter - gramercy

----

AMAZON

ec2-user@54.172.208.134


sudo /sbin/service mysqld start

root - gramercy@#$%^
peter - gramercy


----
see processes
pgrep -l -u bridgedev
pgrep -l -u ec2-user
---

kil all php
pkill -9 php
----

see log
tail -f /home/bridgedev/google-packages/data.log
tail -f /home/ec2-user/google-packages/data.log

----

count files
ls -l | grep ^- | wc -l


---------

concat files

cat /home/bridgedev/google-packages/logs/*csv > /home/bridgedev/google-packages/google-packages1.csv
cat /home/ec2-user/google-packages/logs/*csv > /home/ec2-user/google-packages/google-packages1.csv

-------

10.0.3.61
bridgedev
On3Br!dge185!
----------
RUN ALL TASK

/usr/bin/php /home/bridgedev/google-packages/runner.php
/usr/bin/php /home/ec2-user/google-packages/runner.php


-----------
RUN TASK WIH PARAMS
/usr/bin/php /home/bridgedev/google-packages/parseparams.php 6000 7000 >data_6000_7000.log &
/usr/bin/php /home/ec2-user/google-packages/parseparams.php  0 1000
/usr/bin/php /home/ec2-user/google-packages/parseparams.php 0 1000 >data_0_1000.log &

