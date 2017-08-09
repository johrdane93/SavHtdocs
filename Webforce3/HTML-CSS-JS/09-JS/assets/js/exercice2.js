/* -- CONSIGNE :

    I. Créer un Tableau 3D "PremierTrimestre" contenant la moyenne d'un étudiant pour plusieurs matières.

    Nous auront donc pour un étudiant, sa moyenne à plusieurs matières.

    Par exemple : Hugo LIEGEARD : [ Francais : 12, Math : 19, Physique 4], ... etc

    Vous allez créez au minimum 5 étudiants.

    II. Afficher sur la page (à l'aide de document.write) pour chaque étudiant, la liste (ul et li) de sa moyenne à chaque matière, puis sa moyenne générale.

-- */

/* -- CONSIGNE :

   I. Créer un Tableau 3D "PremierTrimestre" contenant la moyenne d'un étudiant pour plusieurs matières.

   Nous auront donc pour un étudiant, sa moyenne à plusieurs matières.

   Par exemple : Hugo LIEGEARD : [ Francais : 12, Math : 19, Physique 4], ... etc

   Vous allez créez au minimum 5 étudiants.

   II. Afficher sur la page (à l'aide de document.write) pour chaque étudiant, la liste (ul et li) de sa moyenne à chaque matière, puis sa moyenne générale.

-- */

// -- Petite fonction de racccourci (lesflemards.js)
function w(t) {
   document.write(t);
}
function l(e) {
   console.log(e);
}

// -- Créer le tableau 3D.
var PremierTrimestre = [
       {
           "nom"       :   "LIEGEARD",
           "prenom"    :   "Hugo",
           "moyenne"   :   {
               "francais"  : 18,
               "math"      : 19,
               "physique"  : 4
           }
       },
       {
           "nom"       :   "LOUNIS",
           "prenom"    :   "Flora",
           "moyenne"   :   {
               "francais"  : 14,
               "math"      : 9,
               "physique"  : 8
           }
       },
       {
           "nom"       :   "IHADADENE",
           "prenom"    :   "Karim",
           "moyenne"   :   {
               "francais"  : 19,
               "math"      : 12,
               "physique"  : 14
           }
       },
       {
           "nom"       :   "CENTONZE",
           "prenom"    :   "Adrien",
           "moyenne"   :   {
               "francais"  : 8,
               "math"      : 13,
               "physique"  : 10
           }
       },
       {
           "nom"       :   "TARIS",
           "prenom"    :   "Julie",
           "moyenne"   :   {
               "francais"  : 20,
               "math"      : 4,
               "physique"  : 9
           }
       }
   ];

// -- Regardons la console.
l(PremierTrimestre);

w("<ol>")
   // -- Je souhaite afficher la liste de mes étudiants.
   for(i = 0 ; i < PremierTrimestre.length ; i++) {



       // -- On récupère l'Objet Etudiant de l'itération.
       var Etudiant = PremierTrimestre[i];

       // -- Appercu dans la console.
       l(Etudiant);

       // --je defini mon nombre de matier et la somme des note a 0;
           var NombreDeMatiere = 0, SommeDesNote = 0;

       // -- Afficher le Prénom et le Nom d'un Etudiant.
       w("<li>")
           w(PremierTrimestre[i].prenom + " " + PremierTrimestre[i].nom);

           w("<ul>")
               for(var matiere in Etudiant.moyenne) {
                  //--1(Etudiant.moyenne[matiere]);
                  NombreDeMatiere++;
                  SommeDesNote += Etudiant.moyenne[matiere];

               //1(Etudiant.moyenne[matiere]);
               w("<li>")
                   w(matiere + " : " + Etudiant.moyenne[matiere]);
               w("</li>")
           } // Fin  de la boucle Matiére
              //--affichage de la moyenne
              w("<li>")
                  w("Strong>Moyenne Générale :</Strong>" +(Math.round(SommeDesNote / NombreDeMatiere)));
              w("</li>")

           w("</ul>")
       w("</li>")
   }
w("</ol>")
