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
- Get all work orders (Admin)  
    **URL**: /api/work_orders/all.php  
    **Method**: GET  

- Get work orders by Status (Admin)  
    **URL**: /api/work_orders/status.php/?status='open'  
    **Method**: GET  

- Get work orders by Assignee (Assignee)     
    **URL**: /api/work_orders/assignee.php/?assignee=3  
    **Method**: GET  

- Get specify work order (Admin)  
    **URL**: /api/work_orders/single.php/?id=1  
    **Method**: GET  

- Create order (Admin)  
    **URL:** /api/work_orders/create.php  
    **Method:** POST  
    ```json
    {
    "street_address" : "Doral Lane 1100",
    "secondary_address" : "",
    "city" : "Texas",
    "state" : "Houston",
    "zip" : "77073",
    "county" : "",
    "country" : "United State",
    "owner" : "James Camacho",
    "start_date" : "2022-05-04",
    "due_date" : "2022-05-09",
    "instructions" : "Great instructions are described",
    "client_name" : "Max Morono",
    "con" : "1234567890",
    "service" : "Software development",
    "access_code" : "1234560",
    "assignee" : 3
    }
    ```
- Update order (Admin)  
    **URL:** /api/work_orders/update.php  
    **Method:** POST  
    ```json
    {
    "id" : 4,
    "street_address" : "Doral Lane 1100",
    "secondary_address" : "",
    "city" : "Texas",
    "state" : "Houston",
    "zip" : "77073",
    "county" : "",
    "country" : "United State",
    "owner" : "James Camacho",
    "start_date" : "2022-05-04",
    "due_date" : "2022-05-09",
    "instructions" : "Great instructions are described",
    "client_name" : "Max Morono",
    "con" : "1234567890",
    "service" : "Software development",
    "access_code" : "1234560",
    "assignee" : 3
    }
    ```
   
- Delete specify work order (Admin)  
    **URL**: /api/work_orders/delete.php/?id=3  
    **Method**: GET  

------------

### Users
- User settings update (All users)  
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
- User password change (All Users)  
    **URL**: /api/users/change_password.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "password" : "123456",
        "confirm_password" : "123456"
    }
    ```

- User status change (Admin)  
    **URL**: /api/users/status.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "status" : "active"
    }
    ```
 