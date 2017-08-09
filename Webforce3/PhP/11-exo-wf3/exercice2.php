<?php
if (isset($_POST['montant']))
{
$montant = $_POST['montant'];
$devisefrom = $_POST['devisefrom'];
$deviseto = $_POST['deviseto'];

$file = file_get_contents('http://www.xe.com/ucc/convert.cgi?Amount='.$montant.'&From='.$devisefrom.'&To='.$deviseto.'');
preg_match('` ([,0-9.]+) '.$deviseto.'`i', $file, $devise);

$total = $devise[1];

?>
<html>
<body>

<form name="devise" action="devise.php" method="post">

Montant : <input type="text" name="montant" value="<?php echo $montant; ?>">
<br />
Devise de départ :
<select name="devisefrom">
<option value="EUR">Euro</option>
<option value="USD">Dollar</option>
<option value="GBP">Livre Sterling</option>
</select>
<br />
Devise finale :
<select name="deviseto">
<option value="EUR">Euro</option>
<option value="USD">Dollar</option>
<option value="GBP">Livre Sterling</option>
</select>
<br />
Conversion :  <?php echo $total.' '.$deviseto; ?>
<br /><br />
<input type="submit" name="valider" value="valider">
</form>


</body>
</html>
<?php

}
else
{
?>
<html>
<body>
<form name="devise" action="devise.php" method="post">
Montant : <input type="text" name="montant">
<br />
Devise de d&eacute;part :
<select name="devisefrom">
<option value="EUR">Euro</option>
<option value="USD">Dollar</option>
<option value="GBP">Livre Sterling</option>
</select>
<br />
Devise finale :
<select name="deviseto">
<option value="EUR">Euro</option>
<option value="USD">Dollar</option>
<option value="GBP">Livre Sterling</option>
</select>
<br />
Conversion :
<br /><br />
<input type="submit" name="valider" value="valider">
</form>


</body>
</html>
<?php
}
?>
