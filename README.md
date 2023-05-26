# ![Revamp Signature](art/signature_revamp.svg)
A better way to find your files in Laravel!

[![Total Downloads](https://img.shields.io/packagist/dt/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)
[![Latest Stable Version](https://img.shields.io/packagist/v/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)
[![License](https://img.shields.io/packagist/l/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)


## Introduction
Revamp takes your normal files hierarchy :
```
📦my-laravel-project
 ┣ 📂app
 ┃ ┣ 📂Http
 ┃ ┃ ┣ 📂Controllers
 ┃ ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┃ ┣ 📜DepartmentController.php
 ┃ ┃ ┃ ┣ 📜SchoolController.php
 ┃ ┃ ┃ ┗ 📜TeacherController.php
 ┃ ┃ ┗ 📂Requests
 ┃ ┃   ┣ 📜StoreDepartmentRequest.php
 ┃ ┃   ┣ 📜StoreSchoolRequest.php
 ┃ ┃   ┣ 📜StoreTeacherRequest.php
 ┃ ┃   ┣ 📜UpdateDepartmentRequest.php
 ┃ ┃   ┣ 📜UpdateSchoolRequest.php
 ┃ ┃   ┗ 📜UpdateTeacherRequest.php
 ┃ ┣ 📂Models
 ┃ ┃ ┣ 📜Department.php
 ┃ ┃ ┣ 📜School.php
 ┃ ┃ ┣ 📜Teacher.php
 ┃ ┃ ┗ 📜User.php
 ┃ ┗ 📂Policies
 ┃   ┣ 📜DepartmentPolicy.phpz
 ┃   ┣ 📜SchoolPolicy.php
 ┃   ┗ 📜TeacherPolicy.php
 ┣ 📂concepts
 ┃ ┣ 📂Department
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┣ 📂School
 ┃ ┃ ┣ 📂views
 ┃ ┃ ┃ ┗ 📜index.blade.php
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Policy.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┣ 📂Teacher
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Policy.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┗ 📂User
 ┃   ┣ 📜Factory.php
 ┃   ┣ 📜migration.php
 ┃   ┗ 📜Model.php
 ┣ 📂database
 ┃ ┣ 📂factories
 ┃ ┃ ┣ 📜DepartmentFactory.php
 ┃ ┃ ┣ 📜SchoolFactory.php
 ┃ ┃ ┣ 📜TeacherFactory.php
 ┃ ┃ ┗ 📜UserFactory.php
 ┃ ┣ 📂migrations
 ┃ ┃ ┣ 📜2014_10_12_000000_create_users_table.php
 ┃ ┃ ┣ 📜2023_05_25_234856_create_schools_table.php
 ┃ ┃ ┣ 📜2023_05_25_234904_create_departments_table.php
 ┃ ┃ ┗ 📜2023_05_25_234911_create_teachers_table.php
 ┃ ┗ 📂seeders
 ┃   ┣ 📜DatabaseSeeder.php
 ┃   ┣ 📜DepartmentSeeder.php
 ┃   ┣ 📜SchoolSeeder.php
 ┃   ┗ 📜TeacherSeeder.php
 ┣ 📂resources
 ┃ ┗ 📂views
 ┃   ┗ 📂school
 ┃     ┣ 📜index.blade.php
 ┃     ┗ 📜show.blade.php
 ┗ 📂routes
   ┣ 📜api.php
   ┣ 📜channels.php
   ┣ 📜console.php
   ┗ 📜web.php
```
And adds a __concepts__ folder filled with __links__ to the important files sorted and grouped by model.
Every change made to thoses files will affect the target file since they are the same file.

> For example, the model `/app/Models.School.php` is the same file as `concepts/School/Model.php`. Easier to find, easier to maintain.
```
📦my-laravel-project
 ┣ 📂concepts
 ┃ ┣ 📂Department
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┣ 📂School
 ┃ ┃ ┣ 📂views
 ┃ ┃ ┃ ┣ 📜index.blade.php
 ┃ ┃ ┃ ┗ 📜show.blade.php
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Policy.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┣ 📂Teacher
 ┃ ┃ ┣ 📜Controller.php
 ┃ ┃ ┣ 📜Factory.php
 ┃ ┃ ┣ 📜migration.php
 ┃ ┃ ┣ 📜Model.php
 ┃ ┃ ┣ 📜Policy.php
 ┃ ┃ ┣ 📜Seeder.php
 ┃ ┃ ┣ 📜StoreRequest.php
 ┃ ┃ ┗ 📜UpdateRequest.php
 ┃ ┗ 📂User
 ┃   ┣ 📜Factory.php
 ┃   ┣ 📜migration.php
 ┃   ┗ 📜Model.php
 ┗ 📂database
   ┣ 📂factories
   ┃ ┣ 📜DepartmentFactory.php
   ┃ ┣ 📜SchoolFactory.php
   ┃ ┣ 📜TeacherFactory.php
   ┃ ┗ 📜UserFactory.php
   ┣ 📂migrations
   ┃ ┣ 📜2014_10_12_000000_create_users_table.php
   ┃ ┣ 📜2023_05_25_234856_create_schools_table.php
   ┃ ┣ 📜2023_05_25_234904_create_departments_table.php
   ┃ ┗ 📜2023_05_25_234911_create_teachers_table.php
   ┗ 📂seeders
     ┣ 📜DatabaseSeeder.php
     ┣ 📜DepartmentSeeder.php
     ┣ 📜SchoolSeeder.php
     ┗ 📜TeacherSeeder.php
```

<style>
    h1+p, h1+p+p {
        display:flex;
        justify-content: center;
        gap: 1ch;
    }
</style>