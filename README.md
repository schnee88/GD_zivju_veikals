&Family Fish Store Website

&What Is This Project?

This is a website for my family’s small fish store.  
Our store never had an online presence, so I decided to change that by building a website and bringing it into the 21st century.  

The website helps customers:
- View the full product catalog online.
- See which items are currently available or coming soon.
- Reserve products online using the shopping cart system.  
  (Online payments will be implemented in a future update.)

---

&&How to Set Up This Project

Run these commands in your terminal to set up the project:

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install

Start up commands:
php artisan serve
npm run dev

If you need to refresh the database and reseed everything, run:
php artisan migrate:fresh --seed