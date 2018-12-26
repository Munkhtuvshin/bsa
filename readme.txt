1. git - https://git-scm.com/downloads
2. php 7.2 - http://php.net/downloads.php
3. mysql 8.0 - https://dev.mysql.com/downloads
4. visual studio code / sublime / atom ...
5. workbench
6. miktex
7. texstudio
8. staruml

1. https://www.fb.com/groups/f.it335.2018.1
2. https://gitlab.com/groups/f.it335-2018
	username: oyutnii kod

git.org

git bash / terminal ashiglan projectoo tatna, ilgeene

Kod anh huulj avah:
1. code huulah havatsruugaa orno. cd command ashiglana
2. git clone https://ba0000000@gitlab.com/f.it335-2018/eschool.git
3. gitlab.com-n password oruulna.

Kodiin oorchloltiig tataj avah:
1. projectiin (eschool) havtasruu orno. cd command ashiglana.
2. git pull
3. gitlab.com-n password oruulna.

Ooriin bichsen kodiig ilgeeh:
1. projectiin (eschool) havtasruu orno. cd command ashiglana.
2. kodiin oorchloltiig burtgene. git add -A
3. ymar oorchlolt hiisnee tailbarlanaj bichne. git commit
4. serverluu oorchloltoo ilgeene. git push
5. gitlab.com-n password oruulna.

Anhaarah zuils:
1. Push hiihiin umnu zaaval Pull hiij avna.
2. Busdiin file deer oorchlolt hiihgui baih.

Kodchlol:
Raw PHP ashiglana. Ooroor helbel ymar neg php framework ashiglahgui.
Object handaltat programmchaliin argaar kod bichne.
view buyu html kod bichih ued zadgai php file ashiglana.

Zagvar:
Belen HTML template ashiglana. eschool/template
Zuvhun huudasnii buttsiig oorsdoo zohion baiguulna

Database:
eschool/document/erd.mwb ERD diagramiin daguu baazaa uusgene
sql commanduudiig file bolgon eschool/database foldert hiine
Daraah commandaar database, user uusgene:
CREATE DATABASE eschool DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci ;
CREATE USER 'project'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON eschool.* TO 'project'@'localhost';
FLUSH PRIVILEGES;
USE eschool;
source /home/.../eschool/database/schema.sql

Ajilluulah:
1. projectiin (eschool) havtasruu orno. cd command ashiglana.
2. php -S localhost:8000
