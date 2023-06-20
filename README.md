# test-task-laravel-api-todo
Test task on Laravel for Drum'N'Code | Laravel API Todo

remove socket value on config/database.php (if use not mamp as local server)

LOCAL BACKUP BD: <br/>
laravel.sql

POSTMAN: <br/>
    
    https://martian-station-976873.postman.co/workspace/Test-Api~128ff122-7a4e-4efb-a9b2-32fae0de990b/collection/16908768-579acbc3-8a78-47dd-9cb0-32e20bbd7d1a?action=share&creator=16908768

<b> OPTIONS </b>: <br/>
Task <br/>
    - status (todo, done)  <br/>
    - priority (1 ... 5)  <br/>
    - title (text)  <br/>
    - sort (createdAt, completedAt, priority)  <br/>
    - sortValue (ASC, DESC) *optional  <br/>
   
<br/>   
<b> EXAMPLE </b>: <br/>
   
    https://example.com/api/task/?sort=createdAt&sortValue=ASC
