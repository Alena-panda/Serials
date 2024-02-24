
<form method="post" action="index.php?page=2" enctype="multipart/form-data" style="background-color:whitesmoke;opacity:0.9;margin-top:5em;">
     <table width="100%" cellspacing="0" cellpadding="5">
   <tr> 
    <td width="200" valign="top">
    <form action="index.php?page=3" method="post">
            <br>
            <div class="col-auto" style="width:500px">
                <label for="loginid" class="visually-hidden">Имя:</label>
                <input type="text" class="form-control" name="login" id="loginid" placeholder="login" />
                <br>
            </div>
            <div class="col-auto" style="width:500px">
                <label for="pass1id"   class="visually-hidden">Пароль:</label>
                <input type="password" class="form-control"  name="pass1" id="pass1id" placeholder="password" />
                <br>
            </div>
            <div class="col-auto" style="width:500px">
                <label for="pass2id"   class="visually-hidden">Повторите пароль:</label>
                <input type="password" class="form-control"  name="pass2" id="pass2id"  placeholder="password again"/>
                <br>
            </div>
            <div class="col-auto" style="width:500px">
                <label for="emailid" class="visually-hidden">Email:</label>
                <input type="text" class="form-control" name="email" id="emailid" placeholder="email" />
                <br>
            </div>   
            <div>
            <input type="hidden" name="MAX_FILE_SIZE" value="500000000"/>
            <input type="file" name="userImage" id="addimg" accept="image/*">
            </div>
            

            <br><div class="col-auto" style="width:500px">
                <input type="submit" id="buttonid" class="btn btn-primary" name="add" value="Регистрация"/>
                <br>
            </div>

        </form>
    </td>
   </tr>
     </table>

       
<?php
   if(isset($_POST['add']))
   {
    if($_POST['pass1']==$_POST['pass2'])
    {
        $userName=htmlspecialchars($_POST['login']);
        $userPass=htmlspecialchars($_POST['pass1']);
        $userEmail=htmlspecialchars($_POST['email']);
        $path="";
        if(is_uploaded_file($_FILES['userImage']['tmp_name']))//кладём изображение пока во временную папку
        {
           
            $path="images/".$_FILES['userImage']['name'];//name - встроенный
            move_uploaded_file($_FILES['userImage']['tmp_name'],$path);
           
        };
        Tools::createUser($userName, $userPass, $path, $userEmail);
    }
    else
    {
        echo "<h1 style='color:red;'>Пароли должны совпадать!</h1>";
    }
   }
?>