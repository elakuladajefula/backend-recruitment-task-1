<?php

// Please add your logic here

    echo "<h1 class='starting-title'>Nice to see you! &#128075;</h1>";

    $ids = array();

    $file = file_get_contents('./dataset/users.json');
    $data = json_decode($file);
    echo "<table class='table'>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Company</th>
            <th></th>
        </tr>
    ";
    foreach ($data as $row) {
        array_push($ids, "button" . $row->id);
        echo "<tr>" .
            "<td>" . $row->name . "</td>" .
            "<td>" . $row->username . "</td>" .
            "<td>" . $row->email . "</td>" .
            "<td>" . $row->address->street . ", " . $row->address->zipcode . " " . $row->address->city . "</td>" .
            "<td>" . $row->phone . "</td>" .
            "<td>" . $row->company->name . "</td>" .
            "<td> 
                <form method='post'>
                    <button class='removeBtn' type='submit' value='Button" . $row->id . "' name='button" . $row->id . "' onclick='refresh()'><i class='fa fa-trash-o'></i></button> 
                </form>
            </td>" .
        "</tr>";
    }
    echo "</table>";

    foreach ($ids as $id) {
        if(array_key_exists($id, $_POST)) {
            remove($id);
            echo("<meta http-equiv='refresh' content='1'>");
        }
    }

    function remove($button) {
        $id = str_replace("button", "", $button);

        $file = file_get_contents('./dataset/users.json');
        $data = json_decode($file, true);
        $arr_index = array();
        foreach ($data as $key => $value) {
            if ($value['id'] == $id) {
                $arr_index[] = $key;
            }
        }
        foreach ($arr_index as $i) {
            unset($data[$i]);
        }
        $data = array_values($data);
        file_put_contents('./dataset/users.json', json_encode($data));?>
        <script type="text/javascript">    
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    <?php }

    echo "<form class='userForm' method='post' action='" . $_SERVER['PHP_SELF'] . "'>
        <label>Name:</label><br>
        <input class='name' type='text' name='name'><span class='error'>*</span><br><br>
        <label>Username:</label><br>
        <input class='username' type='text' name='username'><span class='error'>*</span><br><br>
        <label>Email:</label><br>
        <input class='email' type='text' name='email'><span class='error'>*</span><br><br>
        <label>Street:</label><br>
        <input class='street' type='text' name='street'><span class='error'>*</span><br><br>
        <label>Zipcode:</label><br>
        <input class='zipcode' type='text' name='zipcode'><span class='error'>*</span><br><br>
        <label>City:</label><br>
        <input class='city' type='text' name='city'><span class='error'>*</span><br><br>
        <label>Phone:</label><br>
        <input class='phone' type='text' name='phone'><span class='error'>*</span><br><br>
        <label>Company:</label><br>
        <input class='company' type='text' name='company'><span class='error'>*</span><br><br>
        <button class='submitBtn' type='submit'>Submit</button>
    </form>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
        $rows = count($ids);
        $lastId = str_replace("button", "", $ids[$rows - 1]);
        $newId = $lastId + 1;
        $jsonObject = new stdClass();
        $jsonObject->id = $newId;
        if (!(empty($_POST["name"])) && preg_match("/^[a-zA-Z-' ]*$/", $_POST["name"])) {
            $jsonObject->name = test_input($_POST["name"]);
        }
        if (!(empty($_POST["username"]))) {
            $jsonObject->username = test_input($_POST["username"]);
        }
        if (!(empty($_POST["email"])) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $jsonObject->email = test_input($_POST["email"]);
        }
        $jsonObject->address = new stdClass();
        if (!(empty($_POST["street"]))) {
            $jsonObject->address->street = test_input($_POST["street"]);
        }
        if (!(empty($_POST["zipcode"]))) {
            $jsonObject->address->zipcode = test_input($_POST["zipcode"]);
        }
        if (!(empty($_POST["city"]))) {
            $jsonObject->address->city = test_input($_POST["city"]);
        }
        if (!(empty($_POST["phone"]))) {
            $jsonObject->phone = test_input($_POST["phone"]);
        }
        if (!(empty($_POST["company"]))) {
            $jsonObject->company = new stdClass();
            $jsonObject->company->name = test_input($_POST["company"]);
        }
        if (!(empty($jsonObject->name)) && !(empty($jsonObject->username)) && !(empty($jsonObject->email)) 
        && !(empty($jsonObject->address->street)) && !(empty($jsonObject->address->zipcode)) 
        && !(empty($jsonObject->address->city)) && !(empty($jsonObject->phone)) && !(empty($jsonObject->company->name))) {
            array_push($data, $jsonObject);
            $jsonData = json_encode($data);
            echo $jsonData;
            file_put_contents('./dataset/users.json', $jsonData);
            ?><script type="text/javascript">    
                if (window.history.replaceState) {
                    window.history.replaceState(null, null, window.location.href);
                }
            </script><?php 
            echo("<meta http-equiv='refresh' content='1'>");
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data, ENT_QUOTES);
        return $data;
      }
?>