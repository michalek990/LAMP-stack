# LAMP-stack

## 1. Czym jest LAMP stack?
LAMP stack to akronim oznaczający zestaw oprogramowania wykorzystywanego do tworzenia dynamicznych stron internetowych i aplikacji. Skrót ten pochodzi od pierwszych liter czterech kluczowych komponentów, które tworzą LAMP stack:
- Linux: System operacyjny na którym działają pozostałe elementy stosu. Linux jest znany ze swojej stabilności, bezpieczeństwa i otwartego kodu źródłowego.
- Apache: Serwer HTTP, który obsługuje żądania przeglądarek internetowych i dostarcza strony internetowe do użytkowników. Apache jest jednym z najpopularniejszych serwerów WWW na świecie.
- MySQL: System zarządzania relacyjnymi bazami danych (RDBMS), który przechowuje dane aplikacji. MySQL jest również oprogramowaniem open source i jest szeroko stosowany w różnych projektach.
- PHP (czasami Perl lub Python): Język skryptowy stosowany do tworzenia dynamicznych treści stron internetowych. PHP działa na serwerze, wykonując kod, który generuje HTML wysyłany do przeglądarki użytkownika.
---
Podsumowując, LAMP stack to kompletny zestaw narzędzi programistycznych umożliwiających tworzenie, testowanie i wdrażanie aplikacji internetowych. Każdy z komponentów pełni określoną rolę, a razem tworzą solidną podstawę dla rozwoju nowoczesnych aplikacji webowych.

## 2. Zastosowanie LAMP stack
### 1. Tworzenie stron internetowych i blogów
LAMP stack jest popularnym wyborem do tworzenia i hostowania dynamicznych stron internetowych oraz blogów. Dzięki PHP można tworzyć dynamiczne treści, a MySQL przechowuje dane użytkowników i treści stron.
- Przykład: WordPress, Joomla, Drupal.
### 2. Systemy zarządzania treścią (CMS)
CMS to aplikacje, które umożliwiają łatwe tworzenie, edytowanie i zarządzanie treściami na stronie internetowej bez konieczności posiadania wiedzy programistycznej.
- Przykład: WordPress jest najbardziej znanym CMS opartym na LAMP stack.
### 3. Aplikacje e-commerce
LAMP stack jest również wykorzystywany do tworzenia platform e-commerce, które umożliwiają handel online. Dzięki niemu można zarządzać produktami, zamówieniami, płatnościami i danymi klientów.
- Przykład: Magento, PrestaShop, OpenCart.
## 4. Forum internetowe
Fora internetowe są popularnymi miejscami do dyskusji online, gdzie użytkownicy mogą tworzyć posty, odpowiadać na nie i uczestniczyć w społeczności.
- Przykład: phpBB, MyBB, SMF (Simple Machines Forum).

## 3. Instalacja LAMP stack
- Atkualizacja systemu
```
sudo apt update
sudo apt upgrade
```
- Instalacja Apache
```
sudo apt install apache2
```
- Instalacja MySQL
```
sudo apt install mysql-server
sudo mysql -u root -p
```
- Instalacja PHP
```
sudo apt install php libapache2-mod-php php-mysql
sudo systemctl restart apache2
```
- Konfiguracja MySQL
```
CREATE DATABASE myapp;

CREATE USER 'myuser' @ 'localhost' IDENTIFIED BY
'mypassword';

GRANT ALL PRIVILAGES ON myapp.* TO 'myuser' @ 'localhost';

FLUSH PRIVILAGES;
```

## 4. Opis implementacji

Podczas instalacji i konfiguracji LAMP stacka oraz wdrażania aplikacji PHP na Kubernetesie wykonaliśmy szereg kroków, które obejmowały instalację poszczególnych komponentów, konfigurację serwera oraz wdrożenie aplikacji. Na początku zainstalowaliśmy system operacyjny Linux, na przykład Ubuntu Server 20.04. Następnie przystąpiliśmy do instalacji serwera Apache za pomocą komendy sudo apt install apache2, a po jego uruchomieniu sprawdziliśmy, czy działa poprawnie.

Kolejnym krokiem była instalacja serwera MySQL przy użyciu komendy sudo apt install mysql-server. Po instalacji skonfigurowaliśmy MySQL za pomocą sudo mysql_secure_installation, co umożliwiło nam zabezpieczenie serwera i ustawienie hasła root. Następnie zainstalowaliśmy PHP oraz niezbędne moduły przy użyciu sudo apt install php libapache2-mod-php php-mysql, aby serwer mógł interpretować skrypty PHP i komunikować się z bazą danych.

Stworzyliśmy przykładową aplikację PHP, która łączy się z bazą danych MySQL i wyświetla dane z tabeli users. Skrypty PHP umieściliśmy w katalogu /var/www/html/myapp, a w pliku config.php zdefiniowaliśmy zmienne konfiguracyjne do połączenia z bazą danych. Następnie skonfigurowaliśmy Apache, tworząc plik konfiguracyjny myapp.conf i dodając w nim VirtualHost wskazujący na naszą aplikację.

Po tych krokach przeprowadziliśmy wdrożenie aplikacji na Kubernetesie. W tym celu stworzyliśmy plik deployment.yaml, który definiował deployment aplikacji PHP z dwoma replikami oraz ConfigMap przechowujący pliki index.php i config.php. Dodaliśmy również Service typu LoadBalancer, aby umożliwić dostęp do aplikacji z zewnątrz, oraz PersistentVolumeClaim do przechowywania danych.

Dla bazy danych MySQL stworzyliśmy plik mysql-deployment.yaml, który definiował deployment MySQL, Service do komunikacji z bazą danych oraz PersistentVolumeClaim do przechowywania danych MySQL. Następnie utworzyliśmy namespace dla aplikacji za pomocą kubectl create namespace myapp i zastosowaliśmy pliki YAML do Kubernetes za pomocą komend kubectl apply -f mysql-deployment.yaml -n myapp oraz kubectl apply -f deployment.yaml -n myapp.

Na koniec sprawdziliśmy status wdrożonych podów i usług za pomocą kubectl get pods -n myapp i kubectl get services -n myapp, aby upewnić się, że wszystkie komponenty działają poprawnie. Użyliśmy zewnętrznego adresu IP wygenerowanego przez LoadBalancer, aby uzyskać dostęp do aplikacji.

Podczas próby uruchomienia MySQL napotkaliśmy na problem związany z brakiem systemd jako systemu init. Aby obejść ten problem, użyliśmy komend sudo service mysql status i sudo service mysql start do zarządzania usługą MySQL. W przypadku dalszych problemów rozważaliśmy uruchomienie MySQL za pomocą Docker, co zapewniłoby bardziej niezawodne środowisko w różnych konfiguracjach systemowych.

## 5. Podsumowanie
LAMP stack, składający się z Linux, Apache, MySQL i PHP, jest popularnym zestawem technologii używanym do budowy i hostowania dynamicznych stron internetowych. Proces instalacji obejmuje zainstalowanie serwera Apache do obsługi HTTP, MySQL jako systemu zarządzania bazą danych oraz PHP jako języka skryptowego do generowania dynamicznych treści. Po zainstalowaniu i skonfigurowaniu tych komponentów, wdrożyliśmy przykładową aplikację PHP, która łączy się z bazą danych MySQL i wyświetla dane na stronie internetowej. Dodatkowo, wdrożyliśmy aplikację na Kubernetesie, korzystając z plików YAML do zdefiniowania deploymentów, usług oraz persistent storage. Cały proces ilustruje, jak zbudować skalowalną i zarządzalną infrastrukturę do hostowania aplikacji internetowych.
