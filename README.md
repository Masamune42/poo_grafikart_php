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
## Refactoring
- On crée un dossier "core" et on y déplace tout ce qui est générique dedans : Connexion à la BDD, Autoloader

## Design Patterns
### Singleton
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

## Injection de dépendances
- Problème : Si on prend la fonction "query()" dans Table.php qui faisait appel à la BDD et utilisait sur la BDD la fonction query avec une requête SQL. Du coup, on a les classes qui communiquent les unes avec les autres (Table <=> Database). Si je veux dissocier les classes les unes des autres c'est gênant, car pour que query() fonctionne dans Table.php, j'ai besoin nécessairement de la BDD : Impossible d'utiliser une classe sans une autre.
- Solution : Injection de dépendances => Si une classe a besoin d'une autre, il faut l'injecter au moment de son constructeur ou au moment de l'appel des fonctions.
```PHP
// Dans index.php
// Crée / récupère l'instance de App
$app = App::getInstance();
// On récupère la table des articles pour tous les récupérer
$posts = $app->getTable('Posts');
var_dump($posts->all());

// Dans App.php
/**
 * Factory : permet d'appeler la Table dont le nom est passé en paramètre
 *
 * @param string $name Nom de la classe
 * @return Table une table qui extends de Table
 */
public function getTable($name)
{
    $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
    // On utilise l'injection de dépendance directement dans la Factory
    return new $class_name($this->getDb());
}

/**
 * Effectue une connexion à la base de données et la garde en instance de classe
 *
 * @return MysqlDatabase Instance de la base de donnée
 */
public function getDb()
{
    $config = Config::getInstance();
    // On récupère une instance de la base de données avec la configuration
    if(is_null($this->db_instance)) {
        $this->db_instance = new MysqlDatabase($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));
    }
    return $this->db_instance;
}

// Dans Table.php
// Variable qui va stocker le base de données utilisée
protected $db;

/**
 * Constructeur par défaut
 *
 * @param \App\Database\Database $db Base de données
 */
public function __construct(\App\Database\Database $db)
{
    // Injection de dépendance => on lie la BDD directement dans le constructeur
    $this->db = $db;
    if (is_null($this->table)) {
        $parts = explode('\\', get_class($this));
        $class_name = end($parts);
        $this->table = strtolower(str_replace('Table', '', $class_name));
    }
}

/**
 * Récupère tous les articles
 *
 * @return PostsTable[] Tableau d'articles
 */
public function all()
{
    // On peut ensuite appeler la BDD dans n'importe quelle fonction
    return $this->db->query('SELECT * FROM articles');
}

/*
DANS CE CODE ON VOIT QUE SI ON CHANGE DE BDD IL FAUDRA LE CHANGER A 2 ENDROITS UNIQUEMENT => dans App->getDb() et dans le constructeur de Table.php
*/
```

## Fluent
```PHP
// Classe permettant de créer des requêtes SQL via des fonctions
class QueryBuilder
{
    private $select = [];

    private $conditions = [];

    private $from = [];

    public function select()
    {
        $this->select = func_get_args();
        return $this;
    }

    public function where()
    {
        foreach (func_get_args() as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function from($table, $alias)
    {
        if (is_null($alias))
            $this->from[] = "$table";
        else
            $this->from[] = "$table AS $alias";
        return $this;
    }

    public function __toString()
    {
        return 'SELECT ' . implode(', ', $this->select)
            . ' FROM ' . implode(', ', $this->from)
            . ' WHERE ' . implode(' AND ', $this->conditions);
    }
}
// Classe d'appel
public function index()
{
    $query = new QueryBuilder();
    // Toutes les fonctions utilisées sont fluent, elles renvoient this, donc elles peuvent être chainées
    echo $query
        ->select('id', 'titre', 'contenu')
        ->where('Post.category_id = 1')
        ->where('Post.date > NOW()')
        ->from('articles', 'Post');
}
```

## Façade
Permet de cacher la complexité du code à travers un appel static. Très présent dans Laravel.
- Avantage : Si change de QueryBuilder dans la façade, cela permettra de le changer qu'à un seul endroit
- Défaut : Cache le code source que l'on a derrière, rend la navigation et la recherche plus complexe
```PHP
class Query
{
    /**
     * Méthode magique (PHP 5.3+) qui permet de rediriger vers QueryBuilder
     *
     * @param string $method Nom de la méthode à appeler
     * @param array $arguments Arguments à passer à la méthode
     * @return void
     */
    public static function __callStatic($method, $arguments)
    {
        $query = new QueryBuilder();
        // Méthode qui permet d'appeler la fonction d'une méthode avec des arguments
        // Ex : méthode select de QueryBuilder avec les arguments
        return call_user_func_array([$query, $method], $arguments);
    }
}
// Classe d'appel
class DemoTable
{
    public function index()
    {
        require ROOT . '/Query.php';
        echo \Query::select('id', 'titre', 'contenu')
            ->where('Post.category_id = 1')
            ->where('Post.date > NOW()')
            ->from('articles', 'Post')
            ->getQuery();
    }
}
```

## Interfaces
```PHP
// Exemple d'implémentation d'interfaces
// Interface qui défini les méthodes à utiliser
interface SessionInterface
{
    public function get($key);

    public function set($key, $value);

    public function delete($key);
}
/**
 * Classe de Session qui implemente SessionInterface
 * Interfaces les plus utilisées :
 * ArrayAccess => Permet d'accéder à un objet comme si c'était un tableau
 * Iterator
 * Count
 */
class Session implements SessionInterface, \Countable, \ArrayAccess
{
    public function __construct()
    {
        session_start();
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

    // On redéfini la méthode count() implémentée par Countable
    public function count()
    {
        return 4;
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetExists($offset)
    {
        return isset($_SESSION[$offset]);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}
// Classe permettant de générer un message flash
class Flash
{
    private $session;

    const KEY = 'gflash';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function set($message, $type = 'success')
    {
        $this->session->set(self::KEY, [
            'message' => $message,
            'type' => $type
        ]);
    }

    public function get()
    {
        $flash = $this->session->get(self::KEY);
        $this->session->delete(self::KEY);
        return "<div class='alert alert-{$flash['type']}'>{$flash['message']}</div>";
    }
}
// Dans index.php
// Création de l'objet flash
$flash = new Grafikart\Flash($session);
// On peut ensuite utiliser la fonction set() de flash pour sauvegarder un message flash
$flash->set('Il y a eu une erreur', 'danger');
// Affichage du message flash sauvegardé
<?= $flash->get(); ?>
```

## Les traits
Permet de gérer un système d'héritage multiple
- Problème : L'héritage (extends) se fait de façon "verticale" => une classe va avoir un parent, qui peut avoir un parent, etc.
- Solution : Utiliser des traits => en général ils définissent des comportements qui se terminent par exemple par "-able" (Rechargeable)
- Avantage : Permet résoudre le problème de créer plusieurs classes presques copiées, ex : Moto, Voiture, Moto électrique, Voiture électrique => Moto, Voiture, Electrique (trait)
- Inconvénients : Rend le code difficile à lire : Quel trait fait quoi et comment il fonctionne avec les autres? Par exemple : pour la fonction rouler() si on veut voir son fonctionnement on remonte dans les héritages classiques, mais comme il y a un des traits qui est utilisé, je vais donc voir comment est définie la fonction à l'intérieur de ceux-ci
- Quand utiliser ou pas les traits :
    - Héritage : Définition d'entité
    - Trait : Comportement