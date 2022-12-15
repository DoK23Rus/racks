# Racks
**Racks** is a prototype of a space accounting system for telecommunication cabinets and racks.

### Stack:
![](https://img.shields.io/badge/python-3.10-blue) ![](https://img.shields.io/badge/django-4.1-%231d915c) ![](https://img.shields.io/badge/django%20REST%20framework-3.13-%23A30000) ![](https://img.shields.io/badge/celery-5.2.7-%23b7df64)  
![](https://img.shields.io/badge/postgreSQL-12.0-%23336791) ![](https://img.shields.io/badge/redis-6.2.7-%23c6302b) ![](https://img.shields.io/badge/mongoDB-4.0.4-%23116149)  
![](https://img.shields.io/badge/node.js-v12.16.1-%2343853d) ![](https://img.shields.io/badge/vue.js-3.2-%2342b883) ![](https://img.shields.io/badge/tailwindCSS-3.2-%230ea5e9)

### Tools and more:
![](https://img.shields.io/badge/docker-20.10.21-%230073ec) ![](https://img.shields.io/badge/docker%20compose-v2.12.2-%230073ec) ![](https://img.shields.io/badge/docker--compose--viz-1.1.0-%230073ec)  
![](https://img.shields.io/badge/flake8-5.0.4-blue) ![](https://img.shields.io/badge/mypy-0.982-blue)  
![](https://img.shields.io/badge/unittest-3.10-blue) ![](https://img.shields.io/badge/selenium-3.141.0-blue) ![](https://img.shields.io/badge/selenium%20grid-4-%23625c98) ![](https://img.shields.io/badge/html--testRunner-1.2.1-blue)  
![](https://img.shields.io/badge/sphinx-2.2.11-%230A507A) ![](https://img.shields.io/badge/drf--yasg-1.21.4-%23A30000)  
![](https://img.shields.io/badge/django--mongolog-0.9.4-%231d915c) ![](https://img.shields.io/badge/django--extensions-3.2.1-%231d915c) ![](https://img.shields.io/badge/django--celery--beat-2.4.0-%231d915c) ![](https://img.shields.io/badge/djoser-2.1.0-%231d915c)  
![](https://img.shields.io/badge/vuelidate-2.0-%2342b883)


### Docker-compose profiles:

For dev environment run:
```
docker-compose --profile dev up
```
For dev environment plus E2E tests run:
```
docker-compose --profile test up
```
![Docker-compose](compose_viz.png)

| ![tree](https://user-images.githubusercontent.com/96002587/202865424-5f57d33c-c63a-408e-9f22-4954feb4a296.png) |
|:--:| 
| *Racks map* |

| ![rack](https://user-images.githubusercontent.com/96002587/202865427-89bec5c8-be2b-4deb-b27d-4561139d4c3a.png) |
|:--:| 
| *Rack scheme* |

| ![device](https://user-images.githubusercontent.com/96002587/202913588-40c33092-f082-41b4-bda2-e986c5b4e89a.png) |
|:--:| 
| *Device card* |
