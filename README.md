# ![Revamp Signature](art/signature_revamp.svg)
## A better way to find your files in Laravel!

[![Total Downloads](https://img.shields.io/packagist/dt/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)
[![Latest Stable Version](https://img.shields.io/packagist/v/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)
[![License](https://img.shields.io/packagist/l/bobanum/revamp)](https://packagist.org/packages/bobanum/revamp)

| [Installation](#installation)
| [Usage](#usage)
| [Configuration](#configuration)
| [The Sources](#the-sources)
| [Custom Sources](#custom-sources)
| [Diagrams](#diagrams)
|

## Introduction

Revamp takes your normal files hierarchy and adds a __\_concepts__ folder filled with __links__ to the important files sorted and grouped by model.
Every change made to thoses files will affect the target file since they are the same file.

> For example, the model `/app/Models.School.php` is the same file as `_concepts/School/Model.php`. Easier to find, easier to maintain.

> See the [diagrams](#diagrams) for more details.

## Installation
````bash
composer require --dev bobabum/revamp
````
## Usage
### Revamp
````bash
php artisan revamp
````
> Will add new links but will not delete obsolete links.

### Revamp back to delete the concepts folder
````bash
php artisan revamp:back
````

### Revamp refresh to delete the concepts folder and recreate it
````bash
php artisan revamp:refresh
````

## Configuration
### Publish the config file
````bash
php artisan vendor:publish --tag=config
````
Will publish the config file `config/revamp.php`

### The configs

| Config              | Description                                                                                                                      | Default                         |
| ------------------- | -------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- |
| `folder_name`       | The folder where the concepts are stored                                                                                         | `_concepts`                     |
| `shorten_names`     | If true, will remove the concept's name from the file name. Making `Table/Controller.php` instead to `Table/TableController.php` | `true`                          |
| `sources`           | 🔜The sources of files for one concept (see [below](#the-sources)). If `sources` is given, only those sources will be rendered.   | `null` for all the sources      |
| `excluded_sources`  | 🔜The sources of files to exclude for one concept. If `excluded_sources` is set, `sources` will be ignored.                       | `null` for no excluded sources  |
| `excluded_concepts` | 🔜The concepts to exclude. Ex.: `['App']`                                                                                         | `null` for no excluded concepts |
| `custom_sources`    | The custom sources to add to the sources. (see [below](#custom-sources))                                                         | `null` for no custom sources    |
custom_sources  

## The Sources

| Source          | Description                                                                                           | Location                  |
| --------------- | ----------------------------------------------------------------------------------------------------- | ------------------------- |
| `Global`        | Some files not linked to a concept                                                                    | Various                   |
| `Model`         | The model file. 🔍Revamp will use found Models to use as concepts                                      | `app/Models`              |
| `Controller`    | The controller file. 🔍Revamp will use found Controllers to use as concepts                            | `app/Http/Controllers`    |
| `Migration`     | The migration file. Revamp will use the migration file __creating__ the table: `*_create_*_table.php` | `database/migrations`     |
| `Seeder`        | The seeder file                                                                                       | `database/seeders`        |
| `Factory`       | The factory file                                                                                      | `database/factories`      |
| `Policy`        | The policy file                                                                                       | `app/Policies`            |
| `Request`       | The requests files (Store and Update)                                                                 | `app/Http/Requests`       |
| `View`          | 🚧 The view folder (not working actually)                                                              | `resources/views`         |
| `Route`         | The route file (if one create a `concept.php` in the `routes` folder)                                 | `routes`                  |
| `VueModel`      | The vuejs file (if one create a `Concept.js` in the `resources/js/models` folder)                     | `resources/js`            |
| `VuePages`      | 🔜 The vuejs `pages` folder                                                                            | `resources/js/pages`      |
| `VueComponents` | 🔜 The vuejs `components` folder                                                                       | `resources/js/components` |

## Custom sources

You can add custom sources to the config file. 
The key is the destination file or folder.
- If the key starts with `/`, the value must then be another array of custom sources and the key will be the destination folder.
- The key (destination) can be a `preg_replace` _replace_ pattern(`$1`, `$2`...). The value (source) must then contain a matching number of `*`. Ex.: `'$2/$1.php' => 'views/*/*.php'`
- The value (source) can be a string or an array. 
- If it's an array: 
  1. the first value will be the source file or `glob` pattern
  2. the second value will be a callable that returns a path like `resource_path` or `base_path`
  3. the third value will be a callable that will let revamp modify the matches for every `*` in the source file or `glob` pattern. Ex.: `fn(&$matches) => $matches[1] = strtoupper($matches[1])`
## Diagrams

<style>
  .columns {
    display: grid;
    grid-template-columns: 1fr max-content;
    justify-content: space-between;
    gap: .5em;
    }
  .columns>div {
    line-height: 1em;
    overflow-x: hidden;
    font-size: 0.8em;
    }
  .columns pre {
    }
  .columns code {
    line-height: 1.1em;
    letter-spacing: -0.1ch;
    white-space: no-wrap !important;
    }
  }
</style>
<div class="columns">
  <div>
    <p>Original Laravel Hierarchy</p>
    <pre><code>📦my-laravel-project
 ┣━📂app
 ┃ ┣━📂Http
 ┃ ┃ ┣━📂Controllers
 ┃ ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┃ ┣━📜DepartmentController.php
 ┃ ┃ ┃ ┣━📜SchoolController.php
 ┃ ┃ ┃ ┗━📜TeacherController.php
 ┃ ┃ ┗━📂Requests
 ┃ ┃   ┣━📜StoreDepartmentRequest.php
 ┃ ┃   ┣━📜StoreSchoolRequest.php
 ┃ ┃   ┣━📜StoreTeacherRequest.php
 ┃ ┃   ┣━📜UpdateDepartmentRequest.php
 ┃ ┃   ┣━📜UpdateSchoolRequest.php
 ┃ ┃   ┗━📜UpdateTeacherRequest.php
 ┃ ┣━📂Models
 ┃ ┃ ┣━📜Department.php
 ┃ ┃ ┣━📜School.php
 ┃ ┃ ┣━📜Teacher.php
 ┃ ┃ ┗━📜User.php
 ┃ ┗━📂Policies
 ┃   ┣━📜DepartmentPolicy.phpz
 ┃   ┣━📜SchoolPolicy.php
 ┃   ┗━📜TeacherPolicy.php
 ┣━📂concepts
 ┃ ┣━📂Department
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┣━📂School
 ┃ ┃ ┣━📂views
 ┃ ┃ ┃ ┗━📜index.blade.php
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Policy.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┣━📂Teacher
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Policy.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┗━📂User
 ┃   ┣━📜Factory.php
 ┃   ┣━📜migration.php
 ┃   ┗━📜Model.php
 ┣━📂database
 ┃ ┣━📂factories
 ┃ ┃ ┣━📜DepartmentFactory.php
 ┃ ┃ ┣━📜SchoolFactory.php
 ┃ ┃ ┣━📜TeacherFactory.php
 ┃ ┃ ┗━📜UserFactory.php
 ┃ ┣━📂migrations
 ┃ ┃ ┣━📜create_users_table.php
 ┃ ┃ ┣━📜create_schools_table.php
 ┃ ┃ ┣━📜create_departments_table.php
 ┃ ┃ ┗━📜create_teachers_table.php
 ┃ ┗━📂seeders
 ┃   ┣━📜DatabaseSeeder.php
 ┃   ┣━📜DepartmentSeeder.php
 ┃   ┣━📜SchoolSeeder.php
 ┃   ┗━📜TeacherSeeder.php
 ┣━📂resources
 ┃ ┗━📂views
 ┃   ┗━📂school
 ┃     ┣━📜index.blade.php
 ┃     ┗━📜show.blade.php
 ┗━📂routes
   ┣━📜api.php
   ┣━📜channels.php
   ┣━📜console.php
   ┗━📜web.php</code></pre>
  </div>
  <div>
    <p>Revamped hierarchy in `_concepts` folder:</p>
      <pre><code>📦my-laravel-project
 ┣━📂_concepts
 ┃ ┣━📂Department
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┣━📂School
 ┃ ┃ ┣━📂views
 ┃ ┃ ┃ ┣━📜index.blade.php
 ┃ ┃ ┃ ┗━📜show.blade.php
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Policy.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┣━📂Teacher
 ┃ ┃ ┣━📜Controller.php
 ┃ ┃ ┣━📜Factory.php
 ┃ ┃ ┣━📜migration.php
 ┃ ┃ ┣━📜Model.php
 ┃ ┃ ┣━📜Policy.php
 ┃ ┃ ┣━📜Seeder.php
 ┃ ┃ ┣━📜StoreRequest.php
 ┃ ┃ ┗━📜UpdateRequest.php
 ┃ ┗━📂User
 ┃   ┣━📜Factory.php
 ┃   ┣━📜migration.php
 ┃   ┗━📜Model.php
 ┗━...</code></pre>
  </div>
</div>
