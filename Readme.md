## API Guide

### User APIs
1. User can register  
2. User can login/logout  
3. User can reset password  
4. User can view all assigned orders  
5. User can view order details 
6. User can take photos
7. User can delete photos
8. User can share photos
9. User can complete order
10. User can view order attachments
11. User can leave comments before completing work order
12. User can upload work orders
13. User can update profile from the app
14. User can view completed orders. (Date completed, date approved, full address, order type).


### Register ✔
- URL ```/api/auth/register.php```  
- Method ```POST```  
    ```json
    {
        "first_name" : "James",
        "last_name" : "Paris",
        "email" : "james@site.com",
        "password" : "123456"
    }
    ```
 
### Login ✔
- URL ```/api/auth/login.php```  
- Method ```POST```  
    ```json
    {
    "email": "devleeqiang@gmail.com",
    "password" : "Slack0206!"
    }
    ```

### Reset Password
- URL ```/api/users/change_password.php```  
- Method ```POST```  
    ```json
    {
        "user_id" : 3,
        "password" : "123456",
        "confirm_password" : "123456"
    }
    ```

### Get all assigned orders
- URL ```/api/work_orders/assignee.php/?assignee=4```
- Method ```GET```

### Get order details
- URL ```/api/work_orders/details.php/?id=1```  
- Method ```GET```  

### Take photos for order
- URL ```/api/work_orders/take_photos.php```  
- Method ```POST```  
    ```json
    {
    "files[]" : "*file upload here",
    "workorder_id" : "8",
    }
    ```

### Delete photos for order
- URL ```/api/work_orders/delete_photos.php```  
- Method ```POST```  
    ```json
    {
    "workorder_id" : "8",
    }
    ```

### Complete order
- URL ```/api/work_orders/status.php```
- Method ```GET```  
    ```json
    {
    "status" : "completed",
    }
    ```
    
### Update Profile
- URL ```/api/users/settings.php```  
- Method ```POST```  
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
### Get order Attachedments
- URL ```/api/work_orders/attachedments.php/?order_id=2```  
- Method  ```GET```  

### Upload work order
- URL ```/api/work_orders/upload.php```  
- Method ```POST```  
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
    "assignee" : 3,
    "files[]" : "*file upload here"
    }
    ```

### Leave comments
- URL ```/api/work_orders/comment.php```  
- Method ```POST```  
    ```json
    {
    "comment" : "doing well",
    "order_id" : 2,
    }
    ```


### Get completed orders  
- URL ```/api/work_orders/status.php/?status='completed'```  
- Method  ```GET```  


## Old version

- Get all work orders (Admin)  
    **URL**: /api/work_orders/all.php  
    **Method**: GET  

- Get work orders by Status (Admin)  
    **URL**: /api/work_orders/status.php/?status='open'  
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
    "assignee" : 3,
    "files[]" : "*file upload here"
    }
    ```

- Attached File uploads only (Admin)  
    **URL:** /api/work_orders/attachedment.php  
    **Method:** POST  
    ```json
    {
    "files[]" : "*file upload here",
    "workorder_id" : "8",
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
- User status change (Admin)  
    **URL**: /api/users/status.php  
    **Method**: POST  
    ```json
    {
        "user_id" : 3,
        "status" : "active"
    }
    ```
 