# Racks
**Racks** is a prototype of a space accounting system for telecommunication cabinets and racks.

### Stack:
- Python 3.10
- Django 4.1
- Django REST framework 3.13
- Celery 5.2.7
- Vue.js 3.2
- TailwindCSS 3.2
- PostgreSQL 12.0
- Redis 6.2.7
- MongoDB 4.0.4 

### Docker-compose profiles:

For dev environment run:
```
docker-compose --profile dev up
```
For dev environment plus E2E tests run:
```
docker-compose --profile test up
```

| ![tree](https://user-images.githubusercontent.com/96002587/202865424-5f57d33c-c63a-408e-9f22-4954feb4a296.png) |
|:--:| 
| *Racks map* |

| ![rack](https://user-images.githubusercontent.com/96002587/202865427-89bec5c8-be2b-4deb-b27d-4561139d4c3a.png) |
|:--:| 
| *Rack scheme* |

| ![device](https://user-images.githubusercontent.com/96002587/202913588-40c33092-f082-41b4-bda2-e986c5b4e89a.png) |
|:--:| 
| *Device card* |
