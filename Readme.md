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
    **URL:** /api/auth/register.php  
    **Method:** POST  
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

- Create order  
    **URL:** /api/auth/register.php  
    **Method:** POST  
    ```json
    {
        "first_name" : "James",
        "last_name" : "Paris",
        "email" : "james@site.com",
        "password" : "123456"
    }
    ```

------------

### Users
- User settings update  
    **URL**: /api/users/settings.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "first_name" : "James",
        "last_name" : "Pat",
        "email" : "james@site.com",
        "phone_number": "1123493939",
        "dob" : "1992-09-02"
    }
    ```
- User password change
    **URL**: /api/users/change_password.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "password" : "123456",
        "confirm_password" : "123456"
    }
    ```

- User status change
    **URL**: /api/users/status.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "status" : "active"
    }
    ```
 