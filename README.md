# Racks
**Racks** is a prototype of a space accounting system for telecommunication cabinets and racks.

| ![tree](https://user-images.githubusercontent.com/96002587/191527448-1186d874-5035-4c29-aa73-4d587fde178d.png) |
|:--:| 
| *Racks map* |

| ![units](https://user-images.githubusercontent.com/96002587/191527487-1da47d9a-9a2f-4e74-b5c3-6a1bed379ec8.png) |
|:--:| 
| *Rack scheme* |

**Tech stack:**
- Python 3.6.9
- Django 2.2.2
- Django REST framework 0.1.0
- Gunicorn 19.9.0
- PostgreSQL 10.18

It's a typical MVP project.  
On the main page there is a diagram of racks in the form of an unfolding tree.
Before adding a rack to fill, you need to create objects to place them. In turn, the rack page displays the units added to it. System prototype also provides the possibility of generating **QR codes** for devices and racks, as well as uploading reports in csv format. * *In order to use the system, you need to add a user to a group with the name of the department.* *
 

| ![device](https://user-images.githubusercontent.com/96002587/191527533-108bd287-e300-437b-9a80-6f47217b9c3d.png) |
|:--:| 
| *Device card* |
