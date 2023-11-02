# Mon projet
Création d'un site web dynamique sur une galerie d'art en ligne, appelée "Galerie Maudoux". Il propose une collection des plus célèbres peintures. Les utilisateurs peuvent naviguer à travers les époques et acheter leur tableau préféré. 

## Contexte de création du site
Site créé dans le cadre de ma formation end éveloppement web, pour le cours d'utilisation du framework Symfony. Plus précisément, c'était le proijet d'examend e mon cours de framework POO. 


# Controllers

##
* [`Accueil`](./src/Controller/HomeController.php)
* [`A propos - Team`](./src/Controller/PageController.php)
* [`Peinture`](./src/Controller/PaintingController.php)
* [`Artiste`](./src/Controller/ArtistController.php)
* [`Article`](./src/Controller/ArticleController.php)
* [`Contact`](./src/Controller/ContactController.php)

### Administration (EasyAdmin)

* [`Utilisateur `](./src/Controller/admin/UserCrudController.php)
* [`Commentaire`](./src/Controller/admin/ArticleCrudController.php)
* [`Peinture`](./src/Controller/admin/PaintingCrudController.php)
* [`Catégorie`](./src/Controller/admin/CategoryCrudController.php)
* [`Technique`](./src/Controller/admin/TechnicalCommentController.php)
* [`Artiste`](./src/Controller/admin/ArtistCrudController.php)
* [`Article`](./src/Controller/admin/ArticleCrudController.php)
* [`Slider`](./src/Controller/admin/SliderCrudController.php)


### User
* [`Inscription`](./src/Controller/user/RegistrationController.php)
* [`Se connecter - se déconnecter`](./src/Controller/user/LoginController.php)
* [`Profil`](./src/Controller/user/UserController.php)
* [`Panier`](./src/Controller/user/CartController.php)


# Templates
* [`Accueil`](./templates/home/home.html.twig)
* [`A propos`](./templates/page/about.html.twig)
* [`L'équipe`](./templates/page/team.html.twig)



* [`La galerie`](./templates/painting/paintings.html.twig)
* [`Détail peinture`](./templates/painting/painting.html.twig)
* [`Les artistes`](./templates/artist/artists.html.twig)
* [`Détail artiste`](./templates/artist/artist.html.twig)
* [`Le journal`](./templates/article/articles.html.twig)
* [`Détail article`](./templates/article/article.html.twig)
* [`Contactez-nous`](./templates/contact/contact.html.twig)
* [`template contact`](./templates/contact/email-css.html.twig)

 ### partials
* [`Header`](./templates/partials/header.html.twig)
* [`Slider`](./templates/partials/slider.html.twig)
* [`Footer`](./templates/partials/footer.html.twig)

### Utilisateurs
* [`S'inscrire`](./templates/user/registration.html.twig)
* [`Se connecter`](./templates/user/login.html.twig)
* [`Profil`](./templates/user/profile.html.twig)
* [`Edition du profil`](./templates/user/profile.html.twig)
* [`Favoris`](./templates/user/wishlist.html.twig)
* [`Panier`](./templates/user/cart.html.twig)
