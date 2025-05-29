<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H1>STUDENT GRADE</H1>
<form method="POST">
    <!-- <label for="name">Name</label> -->
    Name:<input type="text" name = "name" required><br><br>
    <!-- <label for="dept">Department</label> -->
    Department:<select name="dept" id="">
        <option value=""></option>
        <option value="software eng">Software eng</option>
        <option value="computer sci">Computer sci</option>
        <option value="information tech">Information tech</option>
    </select><br><br>
    <!-- <label for="matric">Matric no</label> -->
    Matric no:<input type="text" name = "matric" required><br><br>
    <!-- <label for="gender">Gender</label> -->
     Gender:
    <!-- <label for="male">Male</label> -->
    Male-<input type="radio" name = "gender" id = "male" value = "male" required>
    <!-- <label for="female">Female</label> -->
    Female-<input type="radio" name = "gender" id = "female" value = "female" required><br><br>
    <!-- <label for="student">Score</label> -->
    Score:<input type="text" name = "student" required><br><BR>

    <button type = "Submit">Submit</button><br>
</form>

<?php
function calcgrade($student) {

    if ($student <= 100 && $student >= 80) {
        echo "<p>Grade: A</p>";
    } elseif ($student <=79 && $student>= 60) {
        echo "<p>Grade: A</p>";
    } else if ($student <=59 && $student>= 50) {
        echo "<p>Grade: C</p>";
    } else if ($student <=49 && $student>= 40) {
        echo "<p>Grade: D</p>";
    } else if ($student <=39 && $student >= 35 ) {
        echo "<p>Grade: E</p>";
    }else if ($student <=34 && $student>= 0) {
        echo "<p>Grade: F</p>";
    }else{
        echo "<p>invalid </p>";
    }
}

if($_SERVER["REQUEST_METHOD"]== "POST"){
    $student = $_POST['student'];
    $name = htmlspecialchars($_POST['name']);
    $dept = htmlspecialchars($_POST['dept']);
    $matric = htmlspecialchars($_POST['matric']);
    $gender = htmlspecialchars($_POST['gender']);
    echo "Name: " . $name. "<br>";
    echo "Department: " . $dept. "<br>" ;
    echo "Matric No: " . $matric. "<br>" ;
    echo "Gender: " . $gender ;
    calcgrade($student);
}

?>
</body>
</html>