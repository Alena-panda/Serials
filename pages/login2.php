<?php
//для HOME
//для входа на сайт. Пишем логин, пароль, проверка наличия пользователя в БД
function loginBob($log,$pass)
{
    $log=trim(htmlspecialchars($log));
    $pass=trim(htmlspecialchars($pass));
    if($log=='' || $pass=='')
    {
        echo "<h3/><span style='color:red;'>все поля должны быть заполнены при входе на сайт!</span><h3/>";
        return false;
    }
    if(strlen($log)<3 || strlen($log)>30 || strlen($pass)<3 || strlen($pass)>30)
    {
        echo "<h3/><span style='color:red;'>Длина пароля и логина должна быть не меньше 3 и не больше 30 символов!</span><h3/>";
        return false;
    }
    $connect=Tools::connect();
    include_once ('pages/classes.php');

    $res=Customers::ShowCustomerfromDb($log, $pass);//Customers Object ( [id] => [login] => Alena [pass] => 1111 [total] => 2 [discount] => 0 [imagepath] => 0 [roleid] => 2 )
    print_r($res);
    
    if($res->roleid==1)
    {
        $_SESSION['radmin']=$log;
    }
    if($res->roleid==2)
    {
        $_SESSION['ruser']=$log;
    }
    else
    {
        echo "<h3/><span style='color:red;'>Такой пользователь не зарегестрирован<span/><h3/>";
        return false;
    }
};

//сценарий для входа зарег-го пользователя
if(isset($_SESSION['ruser']))//если сейчас пользователь зашёл на сайт
{
    echo '<form action="index.php';
    if(isset($_GET['page']))//мы сейчас на странице или в индексе?
    {
        echo '?page='.$_GET['page'];
    }
    echo '"method="POST">';

    echo '<h4>Добро пожаловать,'.$_SESSION['ruser'];
    echo '<br><br><input type="submit" value="Выход" id="ex" name="ex"></h4>';
    echo '</form>';

    if(isset($_POST['ex'])) //name="ex"
    {
        unset($_SESSION['ruser']);//удалить ячейку в сессии
        unset($_SESSION['radmin']);//удалить ячейку в сессии чтобы не видить админские страницы
        echo '<script>window.location.reload()</script>';       
    }
}
    else
    {
        if(isset($_POST['press']))//кнопка LOGIn - зайти по логину и паролю в сессию если пользователь есть в БД
        {
            if(loginBob($_POST['login'],$_POST['pass']))  //если вернулась true - т.е. логин и пароль совпали с БД
            {
               echo '<script>window.location.reload()</script>'; //обновилась страница
            }
        }
               echo '<p>Добро пожаловать, Гость!</p> ';
               echo '<p>Зарегеcтрируйтесь, чтобы выбрать множество сериалов!</p>';
    }              
?>
