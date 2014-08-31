Gallery Photo
=======

This is a web photo gallery, using the [mgn-meta project].

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
* [Blueimp Gallery] "slightly modified"

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

##### Configure *.json files.

* config/mysql.json --> sets param for BDD
* config/param.json --> sets title of the pages, footer contact link, title of the main page  
* config/admin.json --> sets login/password for the admin tools page

Add new gallery
---------------

With the [mgn-meta project] tool edit your metadata on your computer, then with an ftp client copy the whole folder on your FTP into "photos" folder (avoid using special chars for the folder name).

/!\ the metadata file must be in your folder containing the photos.
At last go to your main page of the gallery.
Thumbnails will be automatically generated, and metadata insert in BDD.

PS : After the insertion of the metadata into the database, the metadata file is deleted.
Once the metadata file deleted, the script don't re-check the existing galleries.
So if you added an image to the gallery, this one will not be taken into account

Remove gallery
--------------

Just delete the folder from the FTP

Admin access page
----------------

http://indexURL/admin/




[mgn-meta project]:https://github.com/Fragan/mgn-meta
[Bootstrap]:http://getbootstrap.com/
[jQuery]:http://jquery.com
[JQuery-ui]:jqueryui.com
[Bootstrap-file-input]:https://github.com/grevory/bootstrap-file-input
[CKEditor]:http://ckeditor.com/
[Blueimp Gallery]:https://github.com/blueimp/Gallery
