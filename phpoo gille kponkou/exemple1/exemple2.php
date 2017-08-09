 <?php
 require_once 'exemple1.php';
 //Constante
 echo  "une constante: ".MonEspace\Test\MYNAME ."<hr>";
 echo "Appel de la fonction get() de l'espace  MonEspace::Test :";
 echo MonEspace\Test\get();

 Use MonEspace\Test;
 echo "Une constante: ". Test\MYNAME ."<hr>";
 echo "Appel de la fonction get() de l'espace  MonEspace::Test :";
 echo Test\get();

 // Objet1
 $moi = new MonEspace\Test\Personne("Moi");

 // objet2
 Use MonEspace\Test\Personne;
 $toi = new Personne("elle");

 // Méthode et fonction du namespace
 echo "Appel de la méthode get() des objet Personne : ";
 echo $toi->get(). "et ".$moi->get();
