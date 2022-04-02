
#Wallet - Promotion Code App

##Requirements
- Php 8x
- Laravel 9x
- Mysql (Mariadb) 10x 
- Git (lastest)
- Composer (lastest)

##Installation
    -> clone project
    git clone repoUrl

    -> install dependencies
    composer install

    -> create .env file, update with your informations 
    cp .env-example .env

    -> create tables on your database
    php artisan migrate

    -> seed your database with default data
    php artisan db:seed

##Extra
- Setted a default user and user's wallet
- Default user can change in AssignPromotionController 
- [create a promotion code](http://your.domain/api/promotion-codes)
    - Method Post
  ```json
    {
    "code": "optional_field",
    "start_date": "2021-12-18 18:30",
    "end_date": "2022-12-18 18:30",
    "amount": 500,
    "quota": 10
    }
    ```
- [assign a code to current user](http://your.domain/api/assign-promotion)
    - Method Post
  ```json
    {
    "code": "NE63PUTOG7Y5"
    }
    ```

- [get a promotion code by id](http://your.domain/api/promotion-codes/1)
    - Method Get
  ```json
    {
    "success": true,
    "data": {
        "id": 1,
        "code": "TWF6BDOA0NPC",
        "amount": "100.00",
        "quota": 9,
        "status": 1,
        "start_date": "2021-12-18 18:30",
        "end_date": "2022-12-18 18:30",
        "users": [
            {
                "id": 1,
                "username": "jacky.carroll",
                "firstname": "Narciso",
                "lastname": "Rippin",
                "email": "gaylord.leo@example.net",
                "wallet": {
                    "id": 1,
                    "user_id": 1,
                    "balance": "671.00",
                    "updated_at": "2022-04-02 13:03"
                }
            }
        ]
      }
    }
    ```
