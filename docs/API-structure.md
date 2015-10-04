The API has teh following models:
Shirt
Color

Those are accessible in multiple ways:
For Shirts (IN PROGRESS):
| HTTP verb       | Endpoint           | Action                      |
| --------------- |:------------------:|:---------------------------:|
| GET             | /shirts            | Get all shirts              |


For Colors:
| HTTP verb       | Endpoint           | Action                      |
| --------------- |:------------------:|:---------------------------:|
| GET             | /colors            | Get a list of all Colors    |
| POST            | /colors            | Add a Color                 |
| GET             | /colors/{id}       | Get color with {id}         |
| PUT             | /colors/{id}       | Update color with {id}      |
| DELETE          | /colors/{id}       | Delete color with {id}      |

