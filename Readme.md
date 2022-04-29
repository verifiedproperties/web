## API Guide
### Authentication
- Login
	**URL:** /api/auth/login.php
	**Method:** GET
	```json
{
    "email": "devleeqiang@gmail.com",
    "password" : "Slack0206!"
}
```

- Register
**URL: ** /api/auth/register.php
**Method: **POST
```json
{
    "first_name" : "James",
    "last_name" : "Paris",
    "email" : "james@site.com",
    "password" : "123456"
}
```

------------

### Work Orders
- Get all work orders
 **URL**: /api/work_orders/all.php
 **Method**: GET
 
- Get specify work order
 **URL**: /api/work_orders/single.php/?id=1
 **Method**: GET
 