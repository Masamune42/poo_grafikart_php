# Blog PHP POO
## Description
Blog en PHP avec le tutoriel : La POO en PHP de Grafikart
<br>
<small>/!\ Tuto plus vieux que celui de l'autre Blog (blog_php_grafikart) mais intéressant de voir / revoir des points</small>

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