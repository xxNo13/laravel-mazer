<h1 align="center">Mazer + Laravel Jetstream</h1>
<p align="center">Mazer is a Admin Dashboard Template that can help you develop faster. We bring Mazer with Laravel starter project. It's completely free and you can use it in your projects.</p>

## Main Template
If you want to check the original template in HTML5 and Bootstrap, [click here](https://github.com/zuramai/mazer) to open template repository.

## Installation
1. Install dependencies
    ```bash
    composer update 
    
    #OR
    
    composer install
    ```
    And javascript dependencies
    ```bash
    yarn install && yarn dev

    #OR

    npm install && npm run dev
    ```

2. Set up Laravel configurations
    ```bash
    copy .env.example .env
    php artisan key:generate
    ```

3. Set your database in .env

4. Migrate database
    ```bash
    php artisan migrate --seed
    ```

5. Serve the application
    ```bash
    php artisan serve
    ```

7. Login credentials

**Email:** admin@gmail.com

**Password:** password
## Contributing
Feel free to contribute and make a pull request.
