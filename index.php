<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php"; ?>

    <div class="container">
        <h1 class="text-center">Users</h1>
        <table class="table">
            <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>email</th>
                <th>phone</th>
                <th>image</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
            if(isset($dbh)) {
                $stm = $dbh->query("SELECT id, name, email, phone, image FROM users");
                foreach($stm as $row) {
                    echo"
                    <tr>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                        <td>$row[2]</td>
                        <td>$row[3]</td>
                        <td><img src='/uploads/$row[4]' width='50' alt=''></td>
                        <td>
                            <a href='/delete.php?id=$row[0]' class='text-danger' data-delete>
                                <i class='bi bi-x'></i>
                            </a>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/footer.php"; ?>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/modals/deleteModal.php"; ?>


<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    window.addEventListener("load", function() {
        const btns = document.querySelectorAll("[data-delete]");
        let hrefDelete = "";
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
        for (i=0; i<btns.length; i++) {
            btns[i].onclick=function(e) {
                e.preventDefault();
                hrefDelete=this.href;
                console.log("DELETE");
                deleteModal.show();
            }
        }
        document.getElementById("modalDeleteYes").onclick = function () {
            axios.post(hrefDelete).then(resp => {
                deleteModal.hide();
                location.reload();
            });
        }
    });
</script>
