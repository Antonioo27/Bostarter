## Progetto sito web BOSTARTER

### DEPLOYMENT SU XAMPP

- installare [xampp](https://www.apachefriends.org/it/index.html)
- installare [composer](https://getcomposer.org/)
- clonare repository
- Modifica il file `config/config.php` per impostare i parametri del tuo database MySQL locale:

### Uso di MongoDB per i Log

- Su Windows: Scarica il file .dll compatibile dalla pagina ufficiale:(https://pecl.php.net/package/mongodb)
- Installare la versione 1.21.0 per PHP 8.2 Thread Safe
- Copialo nella cartella ext/ di PHP e aggiungi questa riga alla fine del tuo php.ini: extension=mongodb
- lanciare `composer update`
- creare il DB tramite phpmyadmin importando i file della cartella migrations
- inserire nel file `C:\Windows\System32\drivers\etc\hosts` la riga `127.0.0.1 Bostarter.test`
- inserire nel file `httpd.conf` di apache il seguente virtualhost
  ```
  <VirtualHost *:80>
  ServerName Bostarter.test
  DocumentRoot "percorso-alla-cartella-di-progetto"
  <Directory "percorso-alla-cartella-di-progetto">
  AllowOverride All
  Require all granted
  </Directory>
  </VirtualHost>
  ```
