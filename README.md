# STUBBORN APPLICATION SYMFONY 7.2

Application développé avec Symfony **7.2**, **Mysql**, **stripe**, et des **fixtures** pour les données tests.

## PRÉREQUIS

- **PHP > 8.2**
- **Composer > 2.5**
- **MySql > 8.0**

## SERVICES EXTERNES

- **Stripe** (compte + clés API)
  - "STRIPE_PUBLIC_KEY"
  - "STRIPE_PRIVATE_KEY"
  - "N° de carte test : 4242 4242 4242 4242 (date future + CVC au choix)"

- **Symfony Mailer** (exemple avec Mailhog en local)
  ```MAILER_DNS="smtp://localhost:1025" ```

## INSTALLATION

1. Cloner le dépot

2. Installer les dépendances  
```composer install```  

3. Création fichier .env.local  
  - APP_ENV=dev  
  - APP_SECRET=clés_secréte  
  - DATABASE_URL="mysql://username:password@127.0.0.1:3306/stubborn"  
  - STRIPE_PUBLIC_KEY=pk_test_****  
  - STRIPE_SECRETE_KEY=sk_test_****  
  - MAILER_DSN=smtp://localhost:1025  

4. Créer la base de donnés et migration  
  - ```php bin/console doctrine:database:create```  
  - ```php bin/console doctrine:migrations:migrate```  

5. Charger les fixtures  
  - ```php bin/console doctrine:fixtures:load```  

6. Lancer l'application  
  - ```php -S 127.0.0.1:8000 -t public```  

### POUR LANCER LES TESTS  
```php bin/phpunit```