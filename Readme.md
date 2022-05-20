## API Guide

### User APIs
------------------------------------

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

### Reset Password ✔
- URL ```/api/users/change_password.php```  
- Method ```POST```  
    ```json
    {
        "user_id" : 3,
        "password" : "123456",
        "confirm_password" : "123456"
    }
    ```

### Get all assigned orders ✔
- URL ```/api/work_orders/assignee.php/?assignee=4```
- Method ```GET```

### Get order details ✔
- URL ```/api/work_orders/details.php/?id=1```  
- Method ```GET```  

## Add Work order photos ✔
- URL ```/api/work_orders/add_attachedment.php```  
- Method ```POST```  
    ```json
    {
    "files[]" : "*file upload here",
    "workorder_id" : "8",
    }
    ```

### Delete specific order photo ✔
- URL ```/api/work_orders/delete_attachedment.php/?id=2?order_id=2```  
- Method ```Get```  

### Delete All photos for order ✔
- URL ```/api/work_orders/delete_attachedments.php/?order_id=2```  
- Method ```GET```  

### Make Work order status Completed  ✔
- URL ```/api/work_orders/change_status.php/?id=2```
- Method ```GET```  

### Update Profile ✔
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
### Get order Attachments ✔
- URL ```/api/work_orders/attachments.php/?order_id=2```  
- Method  ```GET```  

### Upload work order ✔  
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

### Get Completed orders ✔
- URL ```/api/work_orders/completed_orders.php```  
- Method  ```GET```  

### Notification for assignee ✔
- URL ```/api/work_orders/notification.php```  
- Method  ```GET```
