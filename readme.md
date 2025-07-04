## Конфиг

    php artisan vendor:publish --provider="Notabenedev\StaffTypes\StaffTypesServiceProvider" --tag=config

## Install
    php artisan migrate
   
    php artisan make:staff-types
                            {--all : Run all}
                            {--models : Export models}
                            {--policies : Export and fill policies}
                            {--controllers : Export controllers}

    npm run dev
