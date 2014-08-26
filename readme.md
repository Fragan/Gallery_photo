Gallery Photo
=======
---
This is a web photo gallery, using the [mgn-meta project].

The metadata.json aren't yet usable.

Demo
----
http://padow.livehost.fr/

Version
------
1.0

Tech
-----------

Gallery Photo uses a number of open source projects to work properly:

* [Bootstrap] 
* [jQuery]
* [JQuery-ui]
* [Bootstrap-file-input]
* [CKEditor]
* [Blueimp Gallery] (slightly modified)

Server requirements
-------------------
* PHP 5.3
* Apache 2.2  
* MySQL 5  

Installation
--------------

##### Copy files to your server FTP
```sh
git clone https://github.com/Padow/Gallery_photo.git
```

##### Deploy database.
* gallery.sql

##### Configure params files.

* config/sql.ini --> sets param for BDD
* config/param.json --> sets title of the pages, footer contact link, title of the main page  
* config/admin.json --> sets login/password for the admin tools page

Add new gallery
---------------

With the [mgn-meta project] tool edit your metadata on your computer, then with an ftp client copy the whole folder on your FTP into "photos" folder (avoid using special chars for the folder name).

At last go to your main page of the gallery.



[mgn-meta project]:https://github.com/Fragan/mgn-meta
[Bootstrap]:http://getbootstrap.com/
[jQuery]:http://jquery.com
[JQuery-ui]:jqueryui.com
[Bootstrap-file-input]:https://github.com/grevory/bootstrap-file-input
[CKEditor]:http://ckeditor.com/
[Blueimp Gallery]:https://github.com/blueimp/Gallery
