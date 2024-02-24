<form action="index.php?page=3" method="post">

<?php
    if(!isset($_SESSION['radmin']) && !isset($_SESSION['ruser']))  //если ты зашёл не зарегестрировано на эту страницу - она тебе не откроется
    {
      echo '<div style="background-color:whitesmoke; opacity:0.9; margin-top:5em; padding:1em;">'; 
      echo 'Пожалуста, зарегестрируйтесь, чтобы просматривать каталог сериалов';
      echo '</div>';
      exit();
    } 
?>    

<form action="index.php?page=3" method="post">

<?php
    echo '<div class="row" id="result" 
          style="background-color:whitesmoke; margin-top:1em; margin-bottom:5em; opacity:0.9; ">'; 
    $items=Item::GetItems();
    foreach ($items as $item)
    {
        $item->Draw();
    }    
    echo '</div>';
?>    
</form>


