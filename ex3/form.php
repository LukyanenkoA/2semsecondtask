<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>Task 3. Lukyanenko Alla 21/1</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div id = "form" style="max-width:800px;  background-color:rgb(230, 141, 206);  margin:auto; margin-bottom:5px; margin-top:5px; padding:10px;">
  <h2>HTML form</h2>

  <form action=""
    method="POST">

    <label>
      1. Your name:<br />
      <input name="fio"
      placeholder="Ivan Ivanov" />
    </label><br />

    <label >
      2. Your email:<br />
      <input name="email"
        type="email"
        placeholder="user@example.com" />
    </label><br />

    <label>
      3. Date of birth:<br />
      <select name="year">
        <?php 
        for ($i = 1922; $i <= 2022; $i++) {
          printf('<option value="%d">%d год</option>', $i, $i);
        }
        ?>
      </select><br />

      4. Your civility:<br/>
    <label><input type="radio" checked="checked"
      name="gender" value="m" />
      male</label>
    <label><input type="radio"
      name="gender" value="f" />
      female</label><br />
      5. Number of limbs:<br/>
    <label><input type="radio" checked="checked"
      name="bodyparts" value="2" />
      2</label>
    <label><input type="radio"
      name="bodyparts" value="3" />
      3</label><br />
    <label><input type="radio"
      name="bodyparts" value="4" />
      4</label><br />
    <label><input type="radio"
      name="bodyparts" value="cannot count" />
      cannot count</label><br />
    <label>
      <!--6. Your superpower (pick one or more):
      <br />
      <select name="superpower"
          multiple="multiple">
          <option value="none" selected="selected">none</option>
          <option value="immortality">immortality</option>
          <option value="invisibility">invisibility</option>
          <option value="levitation">levitation</option>
      </select>
      </label><br />
      <label>-->
      7. Your biography:<br />
        <textarea name="bio" placeholder="user@example.com"></textarea>
        </label><br />
        
      8.<label><input type="checkbox" checked="checked"
        name="check" />
        read and understood</label>

      <input type="submit" value="Send" />
    </form>
  </div>
</body>
