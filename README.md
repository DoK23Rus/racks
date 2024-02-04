# Racks
**Racks** is a prototype of a space accounting system for telecommunication cabinets and racks.

### Stack:
![](https://img.shields.io/badge/php-8.1-%23625c98) ![](https://img.shields.io/badge/laravel-10-%23c6302b) ![](https://img.shields.io/badge/MySQL-8.0-%23336791)  
![](https://img.shields.io/badge/vue.js-3.2-%2342b883) ![](https://img.shields.io/badge/tailwindCSS-3.2-%230ea5e9)  
![](https://img.shields.io/badge/python-3.10-blue)

### Tools and more:
![](https://img.shields.io/badge/sail-%23c6302b) ![](https://img.shields.io/badge/larastan-%23c6302b) ![](https://img.shields.io/badge/telescope-%23c6302b) ![](https://img.shields.io/badge/pint-%23c6302b)  
![](https://img.shields.io/badge/phpunit-%23625c98) ![](https://img.shields.io/badge/phpMyAdmin-%23625c98) ![](https://img.shields.io/badge/tymon/jwt--auth-%23625c98) ![](https://img.shields.io/badge/darkaonline/l5--swagger-%23625c98)  
![](https://img.shields.io/badge/unittest-blue) ![](https://img.shields.io/badge/selenium-blue) ![](https://img.shields.io/badge/concurrent.futures-blue) ![](https://img.shields.io/badge/html--testRunner-blue) ![](https://img.shields.io/badge/selenium%20grid-blue)    
![](https://img.shields.io/badge/vuelidate-%2342b883) ![](https://img.shields.io/badge/axios-%2342b883) ![](https://img.shields.io/badge/vuex-%2342b883) ![](https://img.shields.io/badge/vue--svg--loader-%2342b883)

### For dev environment:
Needs `docker` and `laravel/sail` to be installed.
```
./vendor/bin/sail up
```

### build_and_test.sh:

Check `NUMBER_OF_THREADS` and `SHM_SIZE` envs before start!  
HTML-reports and screenshots are stored in relevant docker volumes. Each run logs stored in `./logs` directory.

### CLI:
Administrative purpose commands for artisan via sail:
```
./vendor/bin/sail artisan `command` {args}
```
Region:
```
create:region {name}
delete:region {id}
update:region {id} {name}
```
Department:
```
create:department {name} {region_id}
delete:department {id}
update:department {id} {name}
```
User:
```
make:user {name} {full_name} {email} {department_id}
delete:user {id}
reset_password:user {id}
update:user {id} {name} {full_name} {email} {department_id}
```

### Screenshots:
| ![tree](https://user-images.githubusercontent.com/96002587/202865424-5f57d33c-c63a-408e-9f22-4954feb4a296.png) |
|:--:| 
| *Racks map* |

| ![rack](https://user-images.githubusercontent.com/96002587/202865427-89bec5c8-be2b-4deb-b27d-4561139d4c3a.png) |
|:--:| 
| *Rack scheme* |

| ![device](https://user-images.githubusercontent.com/96002587/202913588-40c33092-f082-41b4-bda2-e986c5b4e89a.png) |
|:--:| 
| *Device card* |


