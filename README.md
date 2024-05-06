# Chef Manuelle Demo Webpage

## Demo

This demo will only be available during the period around the examination period. 06-08 of 2024. If you want to access this webpage after this period please contact me to restart the server. 

You can find the project full documentation in the `/docs/documentation.pdf`.

You can find the demo here: [Webpage](http://161.22.40.113/)


## Technologies used

- Deployment: VPS with LAMP stack (completely installed and setted up via SSH PuTTy commands)
- Vanilla PHP
- Vanilla JavaScript
- Css
- HTML5


## Installation

0. **DISCLAIMER**: Be aware that in order for this project to run as expected has to be placed in the root of the server, so that the canonical url is `/`. Also take into account that for the request flow to work properly the .htaccess should be able to override the server configuration. This can be achieved by allowing it in the apache2.conf or similar file that you can find in your server, you should allow overrides for this project.

1. **IMPORTANT**: As this code is a demo, I programmed a seed route that you can reach by making a GET request to `/seed`. This route depends on an environmental variable called `ENVIRONMENT` and it is being handled in the `/src/App/Seed` folder. If this variable's value is `'dev'`, this route will seed the database with pre-populated data so you can directly seed your database and have a demo of how the webpage will look like in a production environment without having to create all the products (optimized demo images are already included in the `/public/assets/storage` folder as you copy or pull the project code) as well as 3 demo users with all the different priviledge levels:

- email: owner@owner.com password:12345678 role: owner(user management + admin priviledges);
- email: admin@admin.com password:12345678 role: admin(product and orders management);
- email: user@user.com password:12345678 role: user (logged in user that has orders priviledges as well as profile priviledges);

In a production environment, it is important to change this variable name to `'prod'` or any other name so that the seed is not executable.

2. Execute the `composer install` command in the console.

3. Serve your project on a server (the domain must point to the root of the server, if you are using XAMPP or other similar app to run the server locally, you must ensure that the code is running in the root of the server so that all links and URLs will work as intended. For example, if you have multiple projects in your XAMPP `htdocs`, you must ensure that when you serve this project, the server is pointing at the `localhost:port/` route and not, for example, at `localhost:port/project-name/`).

4. Create a MySQL database, the database creation queries can be found at `/docs/data-base-creation-query.sql`. Make sure to fill the `.env` with your variables.

5. Start the database server as well as your database server.

6. Make a GET request to the `/seed` route to seed the database.

7. Go to the menu page, you should visualize the dishes with the demo information.

8. If you want to create accounts you can just use the log in and register functionality, but it is important to know, that if you want extended priviledges you would have to manually change the role of your account to 'owner' in the database (there are 2 privilege levels 'admin' which can just manage the menu and 'owner' who can manage users and the menu, if you want to change the role of an 'owner' you should do it from their account or manually in the database, but an owner can not downrole another owner). From there you can administer users, promote then and manage the menu, but the first high priviledge role must be manually inputed in the database.

9. That was all.
