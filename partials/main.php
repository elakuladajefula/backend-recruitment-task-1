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

    echo "<br><form class='userForm' action='/action_page.php'>
        <label>Name:</label><br>
        <input type='text' id='name' name='name'><br><br>
        <label>Username:</label><br>
        <input type='text' id='username' name='username'><br><br>
        <label>Email:</label><br>
        <input type='text' id='email' name='email'><br><br>
        <label>Address:</label><br>
        <input type='text' id='address' name='address'><br><br>
        <label>Phone:</label><br>
        <input type='text' id='phone' name='phone'><br><br>
        <label>Company:</label><br>
        <input type='text' id='company' name='company'><br><br>
        <input class='submitBtn' type='submit' value='Submit'>
    </form> "
?>