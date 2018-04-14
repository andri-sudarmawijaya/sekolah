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

Daftar Nama Sekolah

### Install via composer

- Development snapshot
```bash
$ composer require bantenprov/sekolah:dev-master
```
- Latest release:

```bash
$ composer require bantenprov/sekolah
```

### Download via github
~~~
bash
$ git clone https://github.com/bantenprov/sekolah.git
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
    Bantenprov\Sekolah\SekolahServiceProvider::class,

```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=sekolah-seeds
```

#### Lakukan Auto Dump :

```bash
$ composer dump-autoload
```

#### Lakukan Seeding :

```bash
$ php artisan db:seed --class=BantenprovSekolahSeeder
$ php artisan db:seed --class=BantenprovJenisSekolahSeeder
$ php artisan db:seed --class=BantenprovProdiSekolahSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=sekolah-assets
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
            path: '/admin/sekolah',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/Sekolah.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Sekolah"
            }
        },
        {
            path: '/admin/sekolah/create',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/Sekolah.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Sekolah"
            }
        },
        {
            path: '/admin/sekolah/:id',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/Sekolah.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Sekolah"
            }
        },
        {
            path: '/admin/sekolah/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/Sekolah.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Sekolah"
            }
        },
    //prodi sekolah
    {
            path: '/admin/prodi-sekolah',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/prodi-sekolah/ProdiSekolah.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Prodi Sekolah"
            }
        },
        {
            path: '/admin/prodi-sekolah/create',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/prodi-sekolah/ProdiSekolah.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Prodi Sekolah"
            }
        },
        {
            path: '/admin/prodi-sekolah/:id',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/prodi-sekolah/ProdiSekolah.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Prodi Sekolah"
            }
        },
        {
            path: '/admin/prodi-sekolah/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/sekolah/prodi-sekolah/ProdiSekolah.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Prodi Sekolah"
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
            name: 'Sekolah',
            link: '/admin/sekolah',
            icon: 'fa fa-angle-double-right'
        },
        {
            name: 'Prodi Sekolah',
            link: '/admin/prodi-sekolah',
            icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//== Sekolah

import Sekolah from './components/bantenprov/sekolah/Sekolah.chart.vue';
Vue.component('echarts-sekolah', Sekolah);

import SekolahKota from './components/bantenprov/sekolah/SekolahKota.chart.vue';
Vue.component('echarts-sekolah-kota', SekolahKota);

import SekolahTahun from './components/bantenprov/sekolah/SekolahTahun.chart.vue';
Vue.component('echarts-sekolah-tahun', SekolahTahun);

import SekolahAdminShow from './components/bantenprov/sekolah/SekolahAdmin.show.vue';
Vue.component('admin-view-sekolah-tahun', SekolahAdminShow);

//== Echarts Group Egoverment

import SekolahBar01 from './components/views/bantenprov/sekolah/SekolahBar01.vue';
Vue.component('sekolah-bar-01', SekolahBar01);

import SekolahBar02 from './components/views/bantenprov/sekolah/SekolahBar02.vue';
Vue.component('sekolah-bar-02', SekolahBar02);

//== mini bar charts
import SekolahBar03 from './components/views/bantenprov/sekolah/SekolahBar03.vue';
Vue.component('sekolah-bar-03', SekolahBar03);

import SekolahPie01 from './components/views/bantenprov/sekolah/SekolahPie01.vue';
Vue.component('sekolah-pie-01', SekolahPie01);

import SekolahPie02 from './components/views/bantenprov/sekolah/SekolahPie02.vue';
Vue.component('sekolah-pie-02', SekolahPie02);

//== mini pie charts


import SekolahPie03 from './components/views/bantenprov/sekolah/SekolahPie03.vue';
Vue.component('sekolah-pie-03', SekolahPie03);

```
