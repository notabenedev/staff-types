## Конфиг

    php artisan vendor:publish --provider="Notabenedev\StaffTypes\StaffTypesServiceProvider" --tag=config

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

## Admin vue component
Vue3

    import ParamsComponent from './components/vendor/staff-types/ParamsComponent.vue'
    app.component('staff-params',ParamsComponent);

Vue2

    php artisan make:staff-types --vue

## Add params to Employee

    use ShouldParams;
## AjaxFormSubmission to Contact's email

    use ShouldStaffOfferEmail;  