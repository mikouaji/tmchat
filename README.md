# About
In 2019 I have created this small chat application to:
- check out websockets and some js stuff
- try making something useful and working in a short time (hackathon style)
- have a place for a small team to talk about project ideas

It took me approximately 24,5h as stated in the commit messages. I was developing in 30 minute intervals.  

I have just found this project still working on an old hosting and moved it here for preservation.

# Functionalities

- session based password protected auth
- login/password changing in app
- creating channels/topics
- sending messages in different channels (live communication)
- unread message count indicator in each topic
- uploading files
- browsing files in different tab (sorting by type)
- rwd

# Stack

(this can be incomplete or incorrect due to me not remembering everything correct)
- PHP 7.2+
- CodeIgniter3
- HashIds
- workerman/phpsocket.io
- MySQL
- KnockoutJS
- Bootstrap
- jQuery
- socket.io
- require.js

# Installation and running

1. Create a MySQL database and import the `db.sql` file.
2. Insert user into `users` table by hand (passwords are hashed with `bcrypt`, you can use `users.type` `ADMIN` but I don't remember if its any different from the default `MEMBER`)
3. Move this code into your webserver root.
4. Run `composer install`
5. In the `app/config` dir copy:
    - `config.sample.php` to `config.php` and fill out the `base_url` var
    - `database.sample.php` to `database.php` and fill out the database connection info
    - `socket.sample.php` to `socket.php` and fill out the `address` and `port` var
6. Configure your server with the domain and port from the socket config.
7. Run the php websocket server with `php server/chat.php`.

###### Configuring the websocket server (points 6. and 7.) might need a bit more work than described. If by any chance you need help post an issue and I'll try helping ;)

# License

- my code: [WTFPL](http://www.wtfpl.net/)
- the rest: as stated in the respected packages/libs
