# ContactForm


___
## Comment installer le projet ?


```
git clone https://github.com/Thierry-Kq/Contact-form.git
cd Contact-form
composer install
```

Vous devrez configurer un accès à une database locale ou distante dans le fichier .env ou .env.local à la racine du projet (voir format du .env). Vous pouvez ensuite créer la database et lancer les fixtures avec les commande :

```
composer fixtures
```

Pour essayer l'application, voici la liste des routes :

``` 
/contact
/administration/messages
```

Pour la partie administration, commentez ```- { path: ^/administration, roles: ROLE_ADMIN }``` dans le fichier config/packages/security.yaml






