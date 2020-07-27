### Installation

1. Clone this repository:

        git clone https://github.com/Anton-94/Booking.git
        
2. Run `docker-compose up` for start docker containers.
3. Run `docker-compose run php-cli bash` command for enter to `php-cli` container.
4. Run `composer install` for install dependencies.
5. Install migrations:
       
       bin/console doctrine:migrations:migrate

6. Install fake data:
    
        bin/console doctrine:fixtures:load
        
7. Now you need to install encore and build assets. 
Run `docker-compose run encore bash` command for enter to `encore` container.
Install node modules `yarn install` and build assets `yarn encore dev`.
      
That's all.

You can launch the app at this `http//:localhost:8005` address
