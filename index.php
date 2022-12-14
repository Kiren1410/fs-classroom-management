<?php

    $database = new PDO('mysql:host=devkinsta_db;dbname=classroom_management','root','33FHSbJDi19BczVZ');
    // var_dump($database);

    $query = $database->prepare('SELECT * FROM students');
    $query->execute();
    $students = $query->fetchAll();

    if (
        isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST'
    ) {
        if ($_POST['action'] === 'add'){
            $statement = $database->prepare(
                "INSERT INTO students (`name` ) VALUES (:name)"     
            );
            $statement->execute(['name' => $_POST['student']]);
    
            header('Location: /');
            exit;
        }

        if($_POST['action'] === 'delete'){
           $statement = $database->prepare('DELETE FROM students WHERE id = :id');
           $statement->execute(['id' => $_POST['student_id']]);
           header('Location: /');
           exit;
        }
    }
    // var_dump($_POST);
    
    // var_dump($_REQUEST); //Combination of $_POST & $_GET
    // var_dump($_SERVER['SERVER_NAME']); //SERVER_NAME //REQUEST_METHOD //REQUEST_URL
    // var_dump($_SERVER['REQUEST_METHOD']);
    // var_dump($_SERVER['REQUEST_URI']);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Classroom Management</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    />
    <style type="text/css">
      body {
        background: #f1f1f1;
      }
    </style>
  </head>
  <body>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">My Classroom</h3>
        <div class="mt-4">
        <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="d-flex justify-content-between align-items-center">
          <input
            type="text"
            class="form-control"
            placeholder="Add new student..."
            name="student"
            required
          />
          <input type="hidden" name="action" value="add" />  
          <button class="btn btn-primary btn-sm rounded ms-2">Add</button>
        </form>
        </div>
      </div>
    </div>
    <div class="card rounded shadow-sm mx-auto my-4" style="max-width: 500px;">
      <div class="card-body">
        <h3 class="card-title mb-3">Students</h3>
        <div class="mt-4">
            <?php foreach ($students as $student) : ?>
                <div class="d-flex justify-content-between mb-2">
                    <?php echo $student['name']; ?>
                   <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                   <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>" />  

                   <input type="hidden" name="action" value="delete" />  
                   <button class="btn btn-danger btn-sm">Delete</button>

                   </form>
                </div>
            <?php endforeach; ?>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
