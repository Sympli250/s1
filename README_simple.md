# Simple.php - Interface UrBackup

Cette page affiche l'interface UrBackup dans un iframe en utilisant le design Symplissime.

## Fonctionnalités

- **Design Symplissime** : Utilise le même design que le reste de l'application avec navigation, tabs et styles cohérents
- **Interface UrBackup** : Affiche l'interface UrBackup dans un iframe redimensionnable
- **URL configurable** : Permet de modifier l'URL du serveur UrBackup via un champ de saisie
- **Tabs interactifs** : Tabs "Total", "Serveurs", "Postes" avec animation et indicateur visuel
- **Responsive** : Interface adaptée pour les écrans de toutes tailles

## Utilisation

1. Accédez à `simple.php`
2. Modifiez l'URL du serveur UrBackup si nécessaire (par défaut: `http://localhost:55414`)
3. Cliquez sur "Charger" pour mettre à jour l'iframe
4. L'interface UrBackup s'affichera dans l'iframe

## Structure des fichiers

- `simple.php` : Page principale avec l'interface
- `includes/header.php` : En-tête avec navigation
- `includes/footer.php` : Pied de page
- `style.css` : Styles CSS
- `navbar.php` : Navigation principale

## Configuration UrBackup

Pour utiliser cette interface avec votre serveur UrBackup :

1. Assurez-vous que votre serveur UrBackup est accessible
2. Modifiez l'URL dans le champ de saisie
3. Cliquez sur "Charger" pour connecter l'interface