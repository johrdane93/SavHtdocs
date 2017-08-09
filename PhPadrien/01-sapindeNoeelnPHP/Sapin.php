<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sapin</title>
  </head>
  <body>
    <form  action="" method="get">
      <label for="nb">taper un chiffre pour cree votre sapin</label>
      <input type="text" name="nb">
      <link rel="stylesheet" href="/css/master.css">
    </form>

    <?php
    $nombre= NULL;
    if(isset($_GET["nb"])){
      $nombre =$_GET["nb"];
    }
    function sapin($parametre){
      if(!isset($parametre)){$parametre=3;echo $parametre;}
      $feuille ="^";
      $tronc   ="|";
      for($j= 0;$j<$parametre;$j++){
        for($i=0;$i<$parametre;$i++){
          echo "<p>" . $feuilles ."</p>";
          $feuilles.="^";
        }
        $feuilles = substr($feuilles,2);
      }
      for ($i=0; $i < $parametre/2; $i++) {
        if ($i==0) {
          for ($j=0; $j < $parametre; $j++) {
            $tronc .="|";
          }
        }
        //echo "<p><center>" . $feuilles . "</center></p>";
        echo "<p>".$tronc."</p>";
      }
    }
    if(isset($_GET["nb"]))
    sapin();
    ?>
  </body>
</html>
