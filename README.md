# chat
Test Chat Symfony

Lancer les commandes suivantes :
<pre>
composer install 
php bin/console make:entity --regenerate
 
php bin/console doctrine:schema:update --force 

echo "Installation terminée"

symfony server:start

</pre>

Une fois les deux utilisateurs créés aller à l'adresse :
<pre>https://127.0.0.1:8000/message/</pre>