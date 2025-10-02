HOW TO SET UP THIS PROJECT

Run these commands:

1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan migrate
4. php artisan db:seed


ja vajag notīrī db un uzreiz ieset datus ( php artisan migrate:fresh --seed )