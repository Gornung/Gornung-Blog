##Gornung -Blog

### Running this blog on you local instance.

* 1 run `composer install` to install all dependencies from composer.json. Creats a vendor directory and the composer.lock.
* 2 create your own `.env` directory use variable names as in `.env.example`
* 3 check you if your database is running
* 4 uncomment for the first time Line 76 in AbstractRepository `$this->createSchema();`
* 5 run `php -S gornung.local:8080` or in your case `localhost`
* 6 signup first time, and recomment the line from Step 4
* 7 go to localhost and enjoy :D 

**HINT:** create a sign up a user named admin (this will have also admin privileges) to delete blogposts
    
**If you imported my Dump then just login as admin**
* username: admin
* password: admin123