This is a demo application for Plan.net, featuring a prize promotion campaign.

Tech stack:

- Symfony 7
- Twig as a template engine
- Bootstrap from CDN
- jQuery from CDN

Install:

- start a HTTP server with PHP 8.x support
- CLI: symfony server:start
- Create a database, a user, and give permissions
- Change DB connector details in ./.env
- Persist migrations: symfony console doctrine:migrations:migrate
- Load fixtures: symfony console doctrine:fixtures:load

Notes:

- All users have the same password: abcdef
- The CSV files from ./public/res/ are loaded on fixture load (change it before runnin fixture load)
- a Setting table is created with a few settings (feel free to tweak it before or after fixture load)

