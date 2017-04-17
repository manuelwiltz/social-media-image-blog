# Welcome to: picblog
A image blog where you can upload, view and share images

# Create database and tables

Before you can start using it, you have to create the database. So login into your phpMyAdmin or what else you are using.

Create a database with the name **picblog**

### Table **posts**
ID is the PRIMARY KEY, so keep in mind that you tick AUTO_INCREMENT and dont't let it be null, so tick NOT NULL.

![grafik](https://cloud.githubusercontent.com/assets/23216069/25089457/d74fb9c2-237d-11e7-9c0b-aae5dd053ca7.png)

### Table **users**
ID is the PRIMARY KEY, so keep in mind that you tick AUTO_INCREMENT and dont't let it be null, so tick NOT NULL.
Do not forget to tick the field **UNIQUE** when creating the field **username**

![grafik](https://cloud.githubusercontent.com/assets/23216069/25089479/02ea8b52-237e-11e7-87c4-e9bc3a026f54.png)
