<?php
//-------------------------------------------БД НАЧАЛО---------------------------------------------
// PDO объект. подключение универсальное к базам данных
class Tools
{
    static function connect($host="localhost:3306",$user="root",$pass="1111",$dbname="serialsDB")
    {
        $connect='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
        $options=array(
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
            );
        try
        {
            $pdo=new PDO($connect,$user,$pass,$options);
            return $pdo;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
            return false;
        }
    }

    //сохранение Юзера в БД со страницы Registration
    static function createUser($name,$pass, $image, $email)
    {
        if($name=="" || $pass=="")
        {
            echo "<h1>Заполните все поля!</h1>";
            return false;
        }
        if(strlen($name)<3 || strlen($pass)<3)
        {
            echo "<h1>длина логина и пароля должна быть больше 3 символов!</h1>";
            return false;
        }
        $obj=new Customers($name, $pass,$image,2,$email,0);//по умолчанию 2 - всегда НЕ админ
        $obj->intoDb();
        echo "<h1>пользователь успешно зарегестрирован!</h1>";
        return true;
    }
}
//-------------------------------------------БД КОНЕЦ-------------------------------------------------------------------------------

//-------------------------------------------КАСТОМЕРСЫ НАЧАЛО------------------------------------------------------------------------
class Customers //только public, т.к. это вкидываем через PDO одной строчкой.
{
    public $id;
    public $login;
    public $pass;
    public $imagepath;
    public $roleid;
    public $email;
    
    function __construct($login, $pass, $imagepath, $roleid, $email, $id=0)
    {
        $this->id=$id;
        $this->login = $login;
        $this->pass = $pass;
        $this->imagepath = $imagepath;
        $this->roleid = $roleid;
        $this->email = $email;
    }

    //запись в Бд
    function intoDb()
    {
        try
        {
            $connect=Tools::connect();
            $select=$connect->prepare("insert into client 
                                     (login, password, imagepath, roleid, email)
                                     values (:login, :pass, :imagepath, :roleid, :email);");//поля как из class Customers
            $ar=(array)$this;  //преобразование объекта класса в массив
            array_shift($ar); //удаляем первый элемент, это id
            $select->execute($ar);//преобразованный массив вставляем в запрос к БД
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    //вытаскивать строку customer из Бд по id
    static function fromDb($id)
    {
        $user=null;
        try
        {
            $con=Tools::connect();
            $ps=$con->prepare("select * from client where id=?"); //в "?" вставляем id, которую мы передали в эту функцию
            $ps->execute(array([$id]));
            $row=$ps->fetch();
            $user=new Customers($row['login'], $row['pass'],$row['imagepath'], $row['roleid'], $row['email'], $row['id']);//поля как из class Customers
            return $user;
        }
        catch(PDOException $e)
        {
            echo "Ошибка ".$e->getMessage();
            return false;
        }
    }

    //вытаскивать строку customer из Бд по логину и паролю
    static function ShowCustomerfromDb($log, $pas)
    {
        $user=null;
        try
        {
            $con=Tools::connect();
            $ps=$con->prepare("select * from client where login=? and password=?"); //в "?" упадёт логин и пароль которые мы передали в эту функцию
            $ps->execute(array($log, $pas));//падает таблица
            $row=$ps->fetch();//падает строка
            $user=new Customers($row['login'], $row['pass'],$row['imagepath'], $row['roleid'], $row['email'], $row['id']);
            return $user;
            //print_r($user); //для проверки админом, что упало в строку
        }
        catch(PDOException $e)
        {
            echo "Ошибка ".$e->getMessage();
            return false;
        }
    }
}
//-------------------------------------------КАСТОМЕР КОНЕЦ------------------------------------------------------------------------

//-------------------------------------------АЙТЕМ НАЧАЛО--------------------------------------------------------------------------
class Item
{
    public $id;
    public $name;
    public $price;
    public $imagepath;
    public $description;

    function __construct($name, $price, $imagepath, $description, $id=0)
    {
        $this->id=$id;
        $this->name = $name;
        $this->price = $price;
        $this->imagepath = $imagepath;
        $this->description = $description;
    }

    //запись в Бд. Если будет нужна админка в самой программе
    // function AddIntoDb()
    // {
    //     try
    //     {
    //         $connect=Tools::connect();
    //         $select=$connect->prepare("insert into item
    //                                  (name, price, imagepath, description) 
    //                                  values 
    //                                  (:name, :price, :imagepath, :description);");//поля как из class Item
    //         $ar=(array)$this;  //преобразование объекта класса в массив
    //         array_shift($ar); //удаляем первый элемент, это id
    //         $select->execute($ar);//преобразованный массив вставляем в запрос к БД
    //     }
    //     catch(PDOException $e)
    //     {
    //         echo "Ошибка ".$e->getMessage();
    //         return false;
    //     }
    // }

    //вытаскивать строку item из Бд по id
    static function ShowfromDb($id)
    {
        $item=null;
     
        try
        {
            $pdo=Tools::connect();
            
            $ps=$pdo->prepare("SELECT*from item where id=?");
            $ps->execute(array($id));//падает таблица
            $row=$ps->fetch();//падает строка
            $item=new Item($row['name'],$row['price'],$row['imagepath'],
                           $row['description'],$row['id']);    
            return $item;        
        }
        catch(PDOException $ex)
        {
            echo "Ошибка ".$ex->getMessage();  
            return false;    
        }
    }

    //чтение товара из БД
    static function GetItems() //0 - все категории
    {
        $array=null; //массив с товарами из БД

        try
     {
        $pdo=Tools::connect();
 
        $select=$pdo->prepare("select * from item;");
        $select->execute();
         while($row=$select->fetch())
        {
            $item=new Item($row['name'], $row['price'], $row['imagepath'],
                        $row['description'], $row['id']);
            $array[]=$item;            
        }
        return $array;
     }

        catch (PDOException $ex)
        {
        echo "Ошибка ".$ex->getMessage();  
        return false;    
        }
    }


    //прорисовка страницы с товарами 
    function Draw()
    {
    echo "<div class='col-sm-3 col-md-3 col-lg-3 container' style='height:325px; border:2px solid lightgrey;'>";

      echo "<div class='row' style='margin-top:2px; background-color:RGB(198,195,181); font-weight:bold;
                height:50px;'>";
        echo "<h5 href='pages/itemInfo.php?name=".$this->id." style='height:120px;'>";//$this->id ай-ди товара
        echo $this->name; //item - поле класса
        echo "</h5>";
      echo "</div>";

        echo "<div style='height:150px; width:130px; margin-top:1px;' class='row'>";
        echo "<img src='".$this->imagepath." 'height='150px'  />";
        echo "</div>";

      echo "<div class='row' style='margin-top:2px; background-color:#ffd2aa;'>";
        echo "<span class='pull-right' style='margin-right:10px;'>";
        echo "Цена: $&nbsp;".$this->price;
        echo "</span>";
      echo "</div>";

      echo "<div class='row' style=''>";
        echo "<p class='text-left' style=' overflow:auto; height:50px; width: 250px;'>";
        echo $this->description;
        echo "</p>";

        $ruser='';
        if(!isset($_SESSION['reg']) || $_SESSION['reg']=="")//если пользователь не зарег-ван
        {
            $ruser="cart_".$this->id;
        }
        else
        {
            $ruser=$_SESSION['reg']."_".$this->id; //логин_id (id товара)
        }
        $id=$this->id;
        //$ruser','$id Логин_id и id товара. Создаём КУКИ!
        
       // include_once('pages/cart.php');
        echo "<button class='btn' style='height:25px;padding:1px;margin:0px;background-color:#F4A900;'
                onclick=createCookie('$ruser','$id')> 
                Добавить вкорзину
              </button>";
      echo "</div>";
    echo "</div>";  
    }

    //вывод товаров в корзину
    function DrawForCart()
    {
    
      echo "<div class='row' style='margin:2px;'>";

        echo "<div style='height:150px; width:130px; margin-top:1px;' class='row'>";
        echo "<img src='".$this->imagepath." 'height='125px'/></div>";
        
        echo "<span style='background-color:#ffd2aa; font-size:20px; height:130px;' class='col-sm-3 col-md-3 col-lg-3'><b>";
        echo $this->name;
        echo "</b><br>";
        echo "$&nbsp;".$this->price;
        echo "</span>";
        
        $ruser='';
        if(!isset($_SESSION['reg']) || $_SESSION['reg']=="")
        {
            $ruser="cart_".$this->id;
        }
        else
        {
            $ruser="cart_".$this->id;
        }
        echo "<button class='col-1 btn btn-danger' style='margin-left:5px;height:30px;width:30px;padding:1px;' onclick=eraseCookie('".$ruser."')>X</button>";
      echo "</div>"; 
                 
    }

    //добавление отчёта о покупках в БД, таблица CART
    function Order()
    {
        try
        {
            $pdo=Tools::connect();
            $ruser='cart';
            if(isset($_SESSION['reg']) && $_SESSION['reg']!="")
            {
                $ruser=$_SESSION['reg'];
            }
            $myInsert="INSERT INTO `cart`(`fk_item`, `fk_client`) 
            VALUES(
                    ( $this->id),  
                    ( SELECT id FROM client WHERE login = ?)
                );";
            $prep=$pdo->prepare($myInsert);
            $prep->execute(array($_SESSION['ruser']));
        }
        catch (Exception $e)    
        {
            echo $e->getMessage();
            return false;
        }
    }
}
//-------------------------------------------АЙТЕМ КОНЕЦ--------------------------------------------------------------------------
?>
<!--------------------------------------- создание и удаление КУКИ------------------------------------------------------------- -->
<script>
        function createCookie(uname, id) //id товара
    {
        var date = new Date(new Date().getTime + 60*1000*30); //60*1000 милисекунд*30 = 30 минут жизнь куки
        document.cookie = uname+"="+id+"; path=/; expires="+date.toUTCString(); //path - где будет видно
    }

    
    function eraseCookie(uname) {
        let theCokies = document.cookie.split(';');
        for (let i = 1; i <= theCokies.length; i++) {
            if (theCokies[i - 1].indexOf(uname) === 1) {
                let theCookie = theCokies[i - 1].split('=');
                let date = new Date(new Date().getTime() - 60000);
                document.cookie = theCookie[0] + "=id; path=/; expires=" + date.toUTCString();
            }
        }
       
    }
</script>