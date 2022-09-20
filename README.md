# Racks
**Racks** is a prototype of a space accounting system for telecommunication cabinets and racks.

| ![racks-5](https://user-images.githubusercontent.com/96002587/157595963-1b22b343-cb10-4eeb-a049-180c0b8be5e7.png) |
|:--:| 
| *Racks map* |

| ![units-4](https://user-images.githubusercontent.com/96002587/156164954-65868778-dff0-4847-bead-bc1edcbd3f9f.png) |
|:--:| 
| *Rack scheme* |

**Tech stack:**
- Python 3.6.9
- Django 2.2.2
- Gunicorn 19.9.0
- PostgreSQL 10.18

It's a typical MVP project.  
On the main page there is a diagram of racks in the form of an unfolding tree.
Before adding a rack to fill, you need to create objects to place them. In turn, the rack page displays the units added to it. System prototype also provides the possibility of generating **QR codes** for devices and racks, as well as uploading reports in csv format. * *In order to use the system, you need to add a user to a group with the name of the department.* *
 

| ![device-4](https://user-images.githubusercontent.com/96002587/156164984-deeee30d-f64e-4958-8609-df86cb2b22ef.png) |
|:--:| 
| *Device card* |

