## Конфиг

    php artisan vendor:publish --provider="Notabenedev\StaffTypes\StaffTypesServiceProvider" --tag=config

## Admin vue component
Vue3

    import ParamsComponent from './components/vendor/staff-types/ParamsComponent.vue'
    app.component('staff-params',ParamsComponent);

Vue2
    
    php artisan make:staff-types --vue

## Install

    php artisan vendor:publish --provider="Notabenedev\StaffTypes\StaffTypesServiceProvider" --tag=public --force
    php artisan migrate
   
    php artisan make:staff-types
                            {--all : Run all}
                            {--models : Export models}
                            {--policies : Export and fill policies}
                            {--controllers : Export controllers}
    init admin vue component
    npm run dev
