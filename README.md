# sekolah

[![Join the chat at https://gitter.im/sekolah/Lobby](https://badges.gitter.im/sekolah/Lobby.svg)](https://gitter.im/sekolah/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/sekolah/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sekolah/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/sekolah/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/sekolah/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/sekolah/v/stable)](https://packagist.org/packages/bantenprov/sekolah)
[![Total Downloads](https://poser.pugx.org/bantenprov/sekolah/downloads)](https://packagist.org/packages/bantenprov/sekolah)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/sekolah/v/unstable)](https://packagist.org/packages/bantenprov/sekolah)
[![License](https://poser.pugx.org/bantenprov/sekolah/license)](https://packagist.org/packages/bantenprov/sekolah)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/sekolah/d/monthly)](https://packagist.org/packages/bantenprov/sekolah)
[![Daily Downloads](https://poser.pugx.org/bantenprov/sekolah/d/daily)](https://packagist.org/packages/bantenprov/sekolah)

Nama Sekolah

### Install via composer

- Development snapshot
```bash
$ composer require bantenprov/group-egovernment:dev-master
```
- Latest release:

```bash
$ composer require bantenprov/group-egovernment
```

### Download via github
~~~
bash
$ git clone https://github.com/bantenprov/group-egovernment.git
~~~

#### Edit `config/app.php` :
```php

'providers' => [

    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //....
    Bantenprov\GroupEgovernment\GroupEgovernmentServiceProvider::class,

```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=group-egovernment-seeds
```

#### Lakukan Auto Dump :

```bash
$ composer dump-autoload
```

#### Lakukan Seeding :

```bash
$ php artisan db:seed --class=Bantenprov_GroupEgovernmentSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=group-egovernment-assets
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/group-egovernment',
            components: {
                main: resolve => require(['./components/bantenprov/group-egovernment/index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Group Government"
            }
        },
        {
            path: '/admin/group-egovernment/create',
            components: {
                main: resolve => require(['./components/bantenprov/group-egovernment/create.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Group Government"
            }
        },
        {
            path: '/admin/group-egovernment/:id',
            components: {
                main: resolve => require(['./components/bantenprov/group-egovernment/show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Group Government"
            }
        },
        {
            path: '/admin/group-egovernment/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/group-egovernment/edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Group Government"
            }
        },
        //== ...
    ]
},

```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
            name: 'Group Government',
            link: '/admin/group-egovernment',
            icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},