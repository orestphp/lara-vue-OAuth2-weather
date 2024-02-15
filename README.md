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
8. Register with https://api.openweathermap.org/data/2.5/weather and set: MAXMIND_LICENSE_KEY, WEATHER_KEY`
9. https://console.cloud.google.com/home/dashboard -> APIs & Services -> Credentials -> OAuth 2.0 Client IDs
```
    a) Authorized JavaScript origins: https://f236-2a02-2378-1238-f4ce-4e0e-d98c-439c-bafa.ngrok-free.app
    b) Authorized redirect URIs: https://f236-2a02-2378-1238-f4ce-4e0e-d98c-439c-bafa.ngrok-free.app/api/google/callback
    c) 'a)' into .env: APP_URL, MIX_APP_URL, MIX_API_URL
```
10. set _./config/services.php_ -> `google` with your credos
11. CLI 1: `php artisan serve`
12. CLI 2: `ngrok http http://127.0.0.1:8000`

NOTE: This app tuned to work with `https` Ngrok to avoid CORS

