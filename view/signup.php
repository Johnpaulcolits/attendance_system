<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <form action="">
        <label for="Student ID">Student ID: </label> 
        <input type="text" name="student_id" id="student_id" required><br>
        <label for="Email address">Email Address</label>
        <input type="text" name="email" id="email" required><br>
        <label for="Firstname"> Firstname</label>
        <input type="text" name="fname" id="fname" required><br>
        <label for="Middle Name">Middle Name</label>
        <input type="text" name="mname" id="mname"  maxlength="1"> <br>
        <label for="Course">Course</label>
        <select name="course" id="course" required> 
            <option value="">Select Option</option>
            <option value="BSIT">BSIT</option>
            <option value="BSIT">BITM</option>
            <option value="BSIT">BSM</option>
            <option value="BSIT">BSCE</option>
        </select><br>
        <label for="Year Level">Year Level</label>
        <select name="year" id="year" required>
            <option value="">Select Option</option>
            <option value="">1st</option>
            <option value="">2nd</option>
            <option value="">3rd</option>
            <option value="">4th</option>
        </select><br>
        <label for="Password">Password</label>  
        <input type="text" name="password" id="password" required><br>
        <label for="Confirm Password">Confirm Password</label>
        <input type="text" name="cinfirmpass" id="cinfirmpass" required><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>