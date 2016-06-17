<div id='title_main' class='boldf'>Règles du jeu</div>

<div id='main_rules'>Les règles de cette compétition sont très simples:<br>
Vous pariez sur le résultat d'un match, ce avant qu'il commence.
<br>
<h4>Points</h4>
<p>En cas de pari correct, vous recevez les points correspondant à la cote du match en question, multipliés par un coefficient selon la phase du tournoi</p>
<table align='center'>
<?php
echo "<tr><td>Premier tour</td><td>".$coef_round['0']." </td></tr>\n";
echo "<tr><td>Huitièmes de finale</td><td>".$coef_round['8']."</td></tr>\n";
echo "<tr><td>Quarts de finale</td><td> ".$coef_round['4']."</td></tr>\n";
echo "<tr><td>Demi-finales</td><td>".$coef_round['2']."</td></tr>\n";
echo "<tr><td>Finales</td><td> ".$coef_round['1']."</td></tr>\n";
?>
</table>
<p>Les cotes sont limitées à <b><?php echo $max_odds;?></b> - pour éviter les extrêmes dûs au nombre de participants relativement petit.</p>

<p>Avant le coup d'envoi du premier match, vous devez choisir un <b> Champion</b>. Vous recevez un bonus de 10 points en cas de pari correct.
Pendant le second tour, si votre vainqueur final est toujours dans la compétition, vous <i> êtes autorisé </i> à parier contre celui-ci.</p>
<p> Avant le coup d'envoi du premier match, vous devez aussi choisir un <b> meilleur buteur de la compétition</b>. Vous recevez 5 points de bonus si vous avez parié sur le bon joueur.

<h4>Problèmes techniques</h4>Si vous avez des problèmes pour entrer vos paris ou si vous anticipez une période sans accès à internet, faites-moi savoir par email à <a href="mailto:vilnico@gmail.com">
email</a>, <u>avant le match</u>, afin que l'on trouve un moyen pour placer vos paris.</i></p>

</div>
