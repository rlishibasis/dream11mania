<?php
$title = "All Users";
include './header.php';
$count_user = mysqli_query($con, "SELECT COUNT(*) FROM user;");
$total = mysqli_fetch_array($count_user);
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="jumbotron" style="margin-top: 15px">
            <h3 class="display-4">All Users</h3>
            <p class="text-muted text-right">Total Users: <?php echo $total[0] ?></p>
            <div class="container-fluid mtb-margin-top">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div id="results">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="output">
                                        <?php include('./includes/get-user.php');?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="loader" style="display:none"><img src="./images/loader.gif" /></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(window).scroll(function() {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 10) {
            if($(window).scrollTop() == ($(document).height() - $(window).height())) {
                var total_pages = parseInt($("#total_pages").val());
                var page = parseInt($("#page").val())+1;
                if(page <= total_pages) {
                    load_more_data(page, total_pages);
                } 
            }
        }
    });
  
    function load_more_data(page, total_pages) {     
        $("#total_pages, #page").remove();     
        $.ajax({
            url: './includes/get-user.php',
            type: "POST",
            data: {page:page},
            beforeSend: function(){
                $(".loader").show();
            },
            complete: function(){
                $('.loader').hide();
                if(page == total_pages) {
                    $(".loader").html('... No more article! ...').show();
                }
            },
            success: function(data){
                $("#output").append(data);
            },
            error: function(){
                $(".loader").html("No data found!");
            }
        });
    }
</script>

<?php
include './footer.php';
?>