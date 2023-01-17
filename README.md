### Rezet

#### Description
Frontend runs on Vue 2, Backend on Laravel 8

#### Installation
1. `git clone`
2. create database and set it in `.env`
3. `php artisan migrate`
4. `composer install`
5. Use node 16: `nvm ls` & `nvm use 16` 
6. `npm install`
7. `npm run dev`
8. `php artisan serve`
9. Set up "ngrok" url
10. set `.env` APP_URL, MIX_APP_URL, MIX_API_URL
11. set `./config/services.php` -> `google` with your credos
12. `ngrok http 80` with your port
NOTE: This app tuned to work with `https` Ngrok, in other case set: `.env` SSL=false

