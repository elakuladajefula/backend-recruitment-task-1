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
        <input type='text' name='name'><br><br>
        <label>Username:</label><br>
        <input type='text' name='username'><br><br>
        <label>Email:</label><br>
        <input type='text' name='email'><br><br>
        <label>Street:</label><br>
        <input type='text' name='street'><br><br>
        <label>Zipcode:</label><br>
        <input type='text' name='zipcode'><br><br>
        <label>City:</label><br>
        <input type='text' name='city'><br><br>
        <label>Phone:</label><br>
        <input type='text' name='phone'><br><br>
        <label>Company:</label><br>
        <input type='text' name='company'><br><br>
        <button class='submitBtn' type='submit'>Submit</button>
    </form>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"])) {
        $rows = count($ids);
        $lastId = str_replace("button", "", $ids[$rows - 1]);
        $newId = $lastId + 1;
        $jsonObject = new stdClass();
        $jsonObject->id = $newId;
        $jsonObject->name = $_POST["name"];
        $jsonObject->username = $_POST["username"];
        $jsonObject->email = $_POST["email"];
        $jsonObject->address = new stdClass();
        $jsonObject->address->street = $_POST["street"];
        $jsonObject->address->zipcode = $_POST["zipcode"];
        $jsonObject->address->city = $_POST["city"];
        $jsonObject->phone = $_POST["phone"];
        $jsonObject->company = new stdClass();
        $jsonObject->company->name = $_POST["company"];
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
?>