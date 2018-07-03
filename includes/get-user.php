<?php
$conn = mysqli_connect("localhost", "root", "", "d11m");
$limit = 10;
if(isset($_POST['page']) && $_POST['page'] != "") {
    $page = $_POST['page'];
    $offset = $limit * ($page-1);
} else {
    $page = 1;
    $offset = 0;
}
$query = "select count(*) 'total_rows' from `user`";
$res = mysqli_fetch_object(mysqli_query($conn, $query));
$total_pages = ceil($res->total_rows/$limit);

$query  = "select * from `user` limit $offset, $limit";
$res = mysqli_query($conn, $query);
if(mysqli_num_rows($res) > 0) {
    $results = "";
    while($row = mysqli_fetch_object($res)) {
        $results .= '<tr>';
        $results .= '<td>'.$row->name.'</td>';
        $results .= '<td>'.$row->phone.'</td>';
        $results .= '<td>'.$row->joined.'</td>';
        $results .= '</tr>';
    }
    $results .= '<input type="hidden" name="total_pages" id="total_pages" value="'.$total_pages.'">';
    $results .= '<input type="hidden" name="page" id="page" value="'.$page.'">';
    echo $results;
}