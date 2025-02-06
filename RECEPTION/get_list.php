<?php

include 'db_connect.php';

$sql_columns = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'students' AND table_schema = 'inferencia2k24_db'";
$result_columns = mysqli_query($conn, $sql_columns);

$res = "";

if ($result_columns && mysqli_num_rows($result_columns) > 0) {
    // Construct the header row
    $res .= "<table><tr>";
    while ($row_columns = mysqli_fetch_assoc($result_columns)) {
        $res .= "<th>" . $row_columns['column_name'] . "</th>";
    }
    $res .= "</tr>";

    // Fetch data from students table
    $sql_data = "SELECT * FROM students";
    $result_data = mysqli_query($conn, $sql_data);

    if ($result_data && mysqli_num_rows($result_data) > 0) {
        while ($row_data = mysqli_fetch_assoc($result_data)) {
            $res .= "<tr>";
            // Iterate over columns to fetch corresponding data
            mysqli_data_seek($result_columns, 0);
            while ($row_columns = mysqli_fetch_assoc($result_columns)) {
                $res .= "<td>" . $row_data[$row_columns['column_name']] . "</td>";
            }
            $res .= "</tr>";
        }
    }

    $res .= "</table>";
} else {
    $res = "Error: Unable to fetch column names";
}

echo $res;
mysqli_close($conn);
?>
