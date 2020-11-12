# Blog PHP POO
## Description
Blog en PHP avec le tutoriel : La POO en PHP de Grafikart
<br>
<small>
/!\ Tuto plus vieux que celui de l'autre Blog (blog_php_grafikart) mais intéressant de voir / revoir des points. Malgré ça, la structure utilisée est plus ancienne et donc souvent plus complexe. Pour cela, revoir plutôt le projet blog_php_grafikart => Apprendre le PHP (Travaux Pratique 2
)
<br>
Ce tuto aborde les design patterns, c'est le point le plus intéressant à voir et comprendre.
</small>

## Tips
- Fonction magique __get
```PHP
/**
 * Fonction magique : si on appelle une variable qui n'existe pas, on utilise cette variable selon nos besoins. ATTENTION : ne pas en abuser (voir ne pas l'utiliser)
 *
 * @param string $key clé de la valeur souhaitée
 * @return void
 */
public function __get($key)
{
    // On récupère la clé pour l'utiliser et appeler une fonction
    $method = 'get' . ucfirst($key);
    // On déclare une nouvelle propriété qui appellera la méthode voulue la prochaine fois qu'on utilisera cette propriété (= utilisation de la méthode magique une seule fois)
    $this->$key = $this->$method();
    return $this->$key;
}
```

## Design Patterns
### Signleton
- Permet d'instancier une classe qu'une seule fois
Actuellement on peut utiliser des classes static mais elles ne peuvent pas disposer de constructeur ET la notion d'héritage est compliquée.
```PHP
// Config.php -> Class Config

private $settings = [];
private static $_instance;

/**
 * Singleton : crée ou récupère l'instance
 *
 * @return self Instance de la classe
 */
public static function getInstance()
{
    // Quand on instancie cette classe, on veut récupérer tous les options del a BDD : user_name, bdd_name...
    if (is_null(self::$_instance)) { // S'il n'y a pas déjà une instance, on la crée
        self::$_instance = new Config();
    }
    // Dans tous les cas, on retourne l'instance de la classe
    return self::$_instance;
}

// En appelant le constructeur, on va récupérer le fichier config.php contenant la configuration dans un tableau
public function __construct()
{
    $this->settings = require __DIR__ . '/config/config.php';
}
```

## Factory
```PHP
// Dans App.php on déclare une fonction qui permet d'appeler différentes tables
/**
 * Factory : permet d'appeler la Table dont le nom est passé en paramètre
 *
 * @param string $name Nom de la classe
 * @return Table une table qui extends de Table
 */
public static function getTable($name)
{
    $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
    return new $class_name();
}

// On peut ensuite appeler cette fonction dans un autre fichier pour récupérer les tables voulues et utiliser les requêtes SQL associées
// On récupère l'instance de l'application
$app = App::getInstance();
// On récupère la table des articles
$posts = $app->getTable('Posts');
$posts = $app->getTable('Categories');
```