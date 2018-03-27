<?php
/**
 * Created by PhpStorm.
 * User: Cedric Edogawa
 * Date: 30/06/2017
 * Time: 20:38
 */

namespace Edogawa\Core\Database;

use Edogawa\Core\Validator\Validation;
use Edogawa\Helpers\ArrayString;

/**
 * Classe QueryBuilder
 *
 * Fournit des méthodes pour créer des requêtes
 *
 * @package Edogawa\Core\Database
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class QueryBuilder
{

    /**
     * La liste des tables concernées par la requête
     *
     * @var string|array
     */
    protected $table;

    /**
     * La requête à exécuter
     *
     * @var string
     */
    protected $requete;

    /**
     * Les paramètres de la requête
     *
     * @var array
     */
    protected $params;

    /**
     * L'objet PDO qui contiendra l'exécution de la requête
     *
     * @var mixed
     */
    protected $query;

    /**
     * Contient les définitions de parenthèses de debut
     *
     * @var string
     */
    protected $bracket = "";

    /**
     * Contient les définitions de parenthèses de fin
     *
     * @var string
     */
    protected $bracketEnd = "";


    /**
     * Transforme un tableau en clause where c'est à dire (attribut1 = 1 and attribut2 = 'Edogawa')
     *
     * @param array $tab
     * @return string
     */
    private function setWhereAdvanced(array $tab)
    {
        foreach ($tab as $value) {
            $explode = explode('|', $value->value);
            if (isset($explode[1])) {
                if ($explode[1] == 'avec') {
                    $where[] = $value->champ . " " . $value->operator . " " . "'" . $explode[0] . "'" . $value->bracket;
                } elseif ($explode[1] == 'sans') {
                    $where[] = $value->champ . " " . $value->operator . " " . $explode[0] . $value->bracket;
                } else if ($explode[1] == 'avec)') {
                    $where[] = $value->champ . " " . $value->operator . " " . "'" . $explode[0] . "'" . $value->bracket;
                } elseif ($explode[1] == 'sans)') {
                    $where[] = $value->champ . " " . $value->operator . " " . $explode[0] . $value->bracket;
                } else {
                    $where[] = $value->champ . " " . $value->operator . " " . (is_string($value->value) ? "'" . $value->value . "'" . $value->bracket : $value->value . $value->bracket);
                }
            } else {
                $where[] = $value->champ . " " . $value->operator . " " . (is_string($value->value) ? "'" . $value->value . "'" . $value->bracket : $value->value . $value->bracket);
            }
        }
        $where = ArrayString::ArrayToString(' ', $where);
        $where = trim($where);
        $where = trim($where, 'AND');
        $where = trim($where, 'OR');
        $where = trim($where);
        return $where;
    }

    /**
     * Ajoute une clause join
     *
     * @param string $instruction
     * @param array $tab
     * @return string
     */
    private function setJoinAdvanced(string $instruction, array $tab)
    {
        $join = array();
        foreach ($tab as $value) {
            $join[] = $instruction . " " . $value->table . " on " . $value->condition;
        }
        $join = ArrayString::ArrayToString(' ', $join);
        return $join;
    }

    /**
     * Génère une clause set c'est à dire (attribut1 = 1 , attribut2 = 'Edogawa')
     *
     * @param array $tab
     * @return string
     */
    private function setSetAdvanced(array $tab)
    {
        foreach ($tab as $value) {
            $explode = explode('|', $value->value);
            if (isset($explode[1])) {
                if ($explode[1] == 'avec') {
                    $where[] = $value->champ . " " . $value->operator . " " . "'" . $explode[0] . "'";
                } elseif ($explode[1] == 'sans') {
                    $where[] = $value->champ . " " . $value->operator . " " . $explode[0];
                } else {
                    $where[] = $value->champ . " " . $value->operator . " " . (is_string($value->value) ? "'" . $value->value . "'" : $value->value);
                }
            } else {
                $where[] = $value->champ . " " . $value->operator . " " . (is_string($value->value) ? "'" . $value->value . "'" : $value->value);
            }
        }
        $where = ArrayString::ArrayToString(' , ', $where);
        return $where;
    }

    /**
     * Agence toutes les clauses Order By
     *
     * @param array $tab
     * @return string
     */
    private function setOrderByAdvanced(array $tab)
    {
        foreach ($tab as $key => $value) {
            $order[] = $value->champ . " " . $value->way;
        }
        return ArrayString::ArrayToString(',', $order);
    }

    /**
     * Agence toutes les clauses Group By
     *
     * @param array $tab
     * @return string
     */
    private function setGroupByAdvanced(array $tab)
    {
        foreach ($tab as $key => $value) {
            $group[] = $value->champ;
        }
        return ArrayString::ArrayToString(',', $group);
    }

    /**
     * ... UNION ...
     * Agence UNION
     * @param $tab
     * @return string
     */
    private function setUnion(array $tab)
    {
        foreach ($tab as $key => $value) {
            $union[] = $value->type."".$value->requete;
        }
        return ArrayString::ArrayToString(' UNION ' , $union);
    }


    /**
     * Agence les attributs et les valeurs pour l'insertion
     *
     * @param array $valeur
     * @return array
     */
    private function setInsertTableAndValues(array $valeur)
    {
        $v = new Validation();
        $tables = "(";
        $values = "";
        foreach ($valeur as $key => $value) {
            $tables .= $key . ',';
            $values .= ($v->validateNumber($value) ? $value . ',' : '\'' . $value . '\',');
        }
        $tables = rtrim($tables, ',');
        $values = rtrim($values, ',');
        $tables .= ")";
        return array($tables, $values);
    }

    /**
     * Commencer une transaction
     *
     * @param string $db
     * @return mixed
     */
    public function beginTransaction(string $db = DEFAULT_DATABASE)
    {
        return Connection::getInstance($db)->beginTransaction();
    }

    /**
     * Commiter une transaction
     *
     * @param string $db
     * @return mixed
     */
    public function commit(string $db = DEFAULT_DATABASE)
    {
        return Connection::getInstance($db)->commit();
    }

    /**
     * Récupérer le dernier id inseré
     *
     * @param string $db
     * @return mixed
     */
    public function lastInsertId(string $db = DEFAULT_DATABASE)
    {
        return Connection::getInstance($db)->lastInsertId();
    }

    /**
     * Annule une transaction
     *
     * @param string $db
     * @return mixed
     */
    public function rollBack(string $db = DEFAULT_DATABASE)
    {
        return Connection::getInstance($db)->rollBack();
    }

    /**
     * Insérer dans la base de données
     *
     * @param string $table
     * @param array $valeurs
     * @param string $db
     * @return int
     */
    public function insert(string $table, array $valeurs, string $db = DEFAULT_DATABASE)
    {
        $insert = $this->setInsertTableAndValues($valeurs);
        $tables = $insert[0];
        $valeur = $insert[1];
        $query = Connection::getInstance($db)->prepare("INSERT INTO {$table}{$tables} VALUES ($valeur)");
        try{
            $r = $query->execute();
            return $r;
        }catch (\Exception $e){
            foreach ($e as $item) {
                echo ($item[2]);
            }
            return 0;
        }
    }


    /**
     * SELECT
     * Générer la portion SELECT de la requête
     * Définit la table sur laquelle sera exécuté la requête
     *
     * @param $table
     * @return QueryBuilder
     */
    public function select($table)
    {
        $this->params['instruction'] = "SELECT";
        $this->params['table'] = is_array($table) ? ArrayString::ArrayToString(',', $table) : $table;
        return $this;
    }

    /**
     * SELECT DISTINCT
     * Générer la portion SELECT DISTINCT de la requête
     *
     * @param $table
     * @return QueryBuilder
     */
    public function selectDistinct($table)
    {
        $this->params['instruction'] = "SELECT DISTINCT";
        $this->params['table'] = is_array($table) ? ArrayString::ArrayToString(',', $table) : $table;
        return $this;
    }

    /**
     * UPDATE
     * Générer la portion UPDATE de la requête
     *
     * @param string $table
     * @return QueryBuilder
     */
    public function update(string $table)
    {
        $this->params['instruction'] = 'UPDATE';
        $this->params['table'] = is_array($table) ? ArrayString::ArrayToString(',', $table) : $table;

        return $this;
    }

    /**
     * DELETE
     * Générer la portion DELETE de la requête
     *
     * @param string $table
     * @return QueryBuilder
     */
    public function delete(string $table)
    {
        $this->params['instruction'] = 'DELETE';
        $this->params['table'] = $table;

        return $this;
    }

    /**
     * UPDATE
     * Génère le set de la requête UPDATE
     *
     * @param string $champ
     * @param string $value
     * @return QueryBuilder
     */
    public function set(string $champ, string $value = 'NULL')
    {
        $this->params['set'][] = (object)array(
            'champ' => $champ,
            'operator' => '=',
            'value' => (empty($value) ? 'NULL' : $value)
        );
        return $this;
    }


    /**
     * Définit les champs concernés par la requête SELECT
     *
     * @param array|string $champ
     * @param string|NULL $alias
     * @return $this
     */
    public function champ($champ, string $alias = NULL)
    {
        is_array($champ) ? $this->params['champ'] = $champ : $this->params['champ'][] = $champ . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT COUNT
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champCount(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "COUNT(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT MAX
     *
     * @param string $champ
     * @param string|null $alias
     * @return QueryBuilder
     */
    public function champMax(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "MAX(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT SUM
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champSum(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "SUM(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT SUM
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champSomme(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "SUM(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT AVG
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champAvg(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "AVG(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT AVG
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champMoyenne(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "AVG(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }

    /**
     * SELECT MIN
     *
     * @param string $champ
     * @param string|NULL $alias
     * @return QueryBuilder
     */
    public function champMin(string $champ, string $alias = NULL)
    {
        $this->params['champ'][] = "MIN(" . $champ . ")" . (!empty($alias) ? ' AS ' . $alias : "");
        return $this;
    }


    /**
     * Définit une parenthèse de debut
     *
     * @return void
     */
    public function bracketStart()
    {
        $this->bracket = "(";
    }

    /**
     * Définit une parenthèse de fin
     *
     * @return void
     */
    public function bracketEnd()
    {
        $this->bracketEnd = ")";
    }

    /**
     * WHERE ...
     * Définit toutes conditions dans le WHERE avec le separateur AND
     *
     * @param string $champ
     * @param string $operator
     * @param string $value
     * @return QueryBuilder
     */
    public function where(string $champ, string $operator, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "AND " . $this->bracket . $champ,
            'operator' => $operator,
            'value' => $value,
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... OR ...
     * Définit toutes conditions dans le WHERE avec le separateur OR
     *
     * @param string $champ
     * @param string $operator
     * @param string $value
     * @return QueryBuilder
     */
    public function orWhere(string $champ, string $operator, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "OR " . $this->bracket . $champ,
            'operator' => $operator,
            'value' => $value,
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... AND .. IN ..
     * Définit toutes conditions dans le WHERE IN avec le separateur AND
     *
     * @param string $champ
     * @param string $value
     * @return QueryBuilder
     */
    public function whereIn(string $champ, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "AND " . $this->bracket . $champ,
            'operator' => 'IN',
            'value' => "('" . implode("','", $value) . "')|sans",
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... OR .. IN ..
     * Définit toutes conditions dans le WHERE IN avec le separateur OR
     *
     * @param string $champ
     * @param string $value
     * @return QueryBuilder
     */
    public function orWhereIn(string $champ, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "OR " . $this->bracket . $champ,
            'operator' => 'IN',
            'value' => "('" . implode("','", $value) . "')|sans",
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... AND .. NOT IN ..
     * Définit toutes conditions dans le WHERE NOT IN avec le separateur AND
     *
     * @param string $champ
     * @param string $value
     * @return QueryBuilder
     */
    public function whereNotIn(string $champ, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "AND " . $this->bracket . $champ,
            'operator' => 'NOT IN',
            'value' => "('" . implode("','", $value) . "')|sans",
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... OR .. NOT IN ..
     * Définit toutes conditions dans le WHERE NOT IN avec le separateur OR
     *
     * @param string $champ
     * @param string $value
     * @return QueryBuilder
     */
    public function orWhereNotIn(string $champ, string $value)
    {
        $this->params['where'][] = (object)array(
            'champ' => "OR " . $this->bracket . $champ,
            'operator' => 'NOT IN',
            'value' => "('" . implode("','", $value) . "')|sans",
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... AND .. LIKE ..
     * Définit toutes conditions dans le WHERE LIKE avec le separateur AND
     *
     * @param string $champ
     * @param string $value
     * @param string $matchCase
     * @return QueryBuilder
     */
    public function whereLike(string $champ, string $value, string $matchCase = 'both')
    {
        $this->params['where'][] = (object)array(
            'champ' => "AND " . $this->bracket . $champ,
            'operator' => 'LIKE',
            'value' => (($matchCase == 'both' or $matchCase == 'gauche-droite') ? "%" . $value . "%" :
                (($matchCase == 'left' or $matchCase == 'gauche') ? "%" . $value :
                    (($matchCase == 'right' or $matchCase == 'droite') ? $value . "%" : "%" . $value . "%"))),
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... OR .. LIKE ..
     * Définit toutes conditions dans le WHERE LIKE avec le separateur OR
     *
     * @param string $champ
     * @param string $value
     * @param string $matchCase
     * @return QueryBuilder
     */
    public function orWhereLike(string $champ, string $value, string $matchCase = 'both')
    {
        $this->params['where'][] = (object)array(
            'champ' => "OR " . $this->bracket . $champ,
            'operator' => 'LIKE',
            'value' => (($matchCase == 'both' or $matchCase == 'gauche-droite') ? "%" . $value . "%" :
                (($matchCase == 'left' or $matchCase == 'gauche') ? "%" . $value :
                    (($matchCase == 'right' or $matchCase == 'droite') ? $value . "%" : "%" . $value . "%"))),
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... AND NOT LIKE ..
     * Définit toutes conditions dans le WHERE NOT LIKE avec le separateur AND
     *
     * @param string $champ
     * @param string $value
     * @param string $matchCase
     * @return QueryBuilder
     */
    public function whereNotLike(string $champ, string $value, string $matchCase = 'both')
    {
        $this->params['where'][] = (object)array(
            'champ' => "AND " . $this->bracket . $champ,
            'operator' => 'NOT LIKE',
            'value' => (($matchCase == 'both' or $matchCase == 'gauche-droite') ? "%" . $value . "%" :
                (($matchCase == 'left' or $matchCase == 'gauche') ? "%" . $value :
                    (($matchCase == 'right' or $matchCase == 'droite') ? $value . "%" : "%" . $value . "%"))),
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }

    /**
     * WHERE ... OR .. NOT LIKE ..
     * Définit toutes conditions dans le WHERE NOT LIKE avec le separateur OR
     *
     * @param string $champ
     * @param string $value
     * @param string $matchCase
     * @return QueryBuilder
     */
    public function orWhereNotLike(string $champ, string $value, string $matchCase = 'both')
    {
        $this->params['where'][] = (object)array(
            'champ' => "OR " . $this->bracket . $champ,
            'operator' => 'NOT LIKE',
            'value' => (($matchCase == 'both' or $matchCase == 'gauche-droite') ? "%" . $value . "%" :
                (($matchCase == 'left' or $matchCase == 'gauche') ? "%" . $value :
                    (($matchCase == 'right' or $matchCase == 'droite') ? $value . "%" : "%" . $value . "%"))),
            'bracket' => $this->bracketEnd
        );
        $this->bracketEnd = "";
        $this->bracket = "";
        return $this;
    }


    /**
     * JOIN ... ON ...
     * Génère la clause join dans la requête
     *
     * @param string $table
     * @param string $condition
     * @return QueryBuilder
     */
    public function join(string $table, string $condition)
    {
        $this->params['join'][] = (object)array(
            'table' => $table,
            'condition' => $condition
        );
        return $this;
    }

    /**
     * LEFT JOIN ... ON ...
     *
     * @param string $table
     * @param string $condition
     * @return QueryBuilder
     */
    public function leftjoin(string $table, string $condition)
    {
        $this->params['leftjoin'][] = (object)array(
            'table' => $table,
            'condition' => $condition
        );
        return $this;
    }

    /**
     * RIGHT JOIN ... ON ...
     *
     * @param string $table
     * @param string $condition
     * @return QueryBuilder
     */
    public function rightjoin(string $table, string $condition)
    {
        $this->params['rightjoin'][] = (object)array(
            'table' => $table,
            'condition' => $condition
        );
        return $this;
    }

    /**
     * INNER JOIN ... ON ...
     *
     * @param string $table
     * @param string $condition
     * @return QueryBuilder
     */
    public function innerjoin(string $table, string $condition)
    {
        $this->params['innerjoin'][] = (object)array(
            'table' => $table,
            'condition' => $condition
        );
        return $this;
    }

    /**
     * OUTER JOIN ... ON ...
     *
     * @param string $table
     * @param string $condition
     * @return QueryBuilder
     */
    public function outerjoin(string $table, string $condition)
    {
        $this->params['innerjoin'][] = (object)array(
            'table' => $table,
            'condition' => $condition
        );
        return $this;
    }


    /**
     * ORDER BY ... ...
     * Génère la clause order by dans la requête select
     *
     * @param string $champ
     * @param string $way
     * @return QueryBuilder
     */
    public function orderBy(string $champ, string $way = "ASC")
    {
        $this->params['orderBy'][] = (object)array(
            'champ' => $champ,
            'way' => $way
        );
        return $this;
    }


    /**
     * GROUP BY ...
     * Génère la clause group by dans la requête select
     *
     * @param string $champ
     * @return QueryBuilder
     */
    public function groupBy(string $champ)
    {
        $this->params['groupBy'][] = (object)array(
            'champ' => $champ
        );
        return $this;
    }

    /**
     * HAVING ...
     * Définit la condition après un group by dans un select
     *
     * @param string $champ
     * @param string $operator
     * @param string $value
     * @return QueryBuilder
     */
    public function having(string $champ, string $operator, string $value)
    {
        $this->params['having'][] = (object)array(
            'champ' => $this->bracket . $champ,
            'operator' => $operator,
            'value' => $value,
            'bracket' => $this->bracketEnd
        );
        return $this;
    }

    /**
     * LIMIT ...,...
     * Limte le nombre de retour de la requête select
     *
     * @param int $deb
     * @param int $nombre
     * @return QueryBuilder
     */
    public function limit(int $deb, int $nombre = 0)
    {
        $this->params['limit'] = (object)array(
            'debut' => $deb,
            'nombre' => $nombre
        );
        return $this;
    }

    /**
     * ... UNION ...
     *
     * @param string $requete
     * @param string $type
     * @return QueryBuilder
     */
    public function union(string $requete , string $type = "")
    {
        $this->params['union'][] = (object)array(
            'requete' => $requete,
            'type' => $type
        );
        return $this;
    }

    private function getDatabase(string $db)
    {
        return DATABASE[$db]['DATABASE'];
    }

    /**
     * Rassemble toutes les instructions données en requête sous forme de requête SQL
     *
     * @param string $db
     * @return string
     */
    public function end(string $db = DEFAULT_DATABASE)
    {
        $p = $this->params;
        if (isset($p['instruction'])){
            if ($p['instruction'] == 'SELECT' or $p['instruction'] == 'SELECT DISTINCT') {
                $this->requete = $p['instruction'] . " " . ArrayString::ArrayToString(',', $p['champ'] ?? '*') .
                    " FROM " . ArrayString::ArrayToString(',', $p['table']) .
                    (isset($p['join']) ? " " . $this->setJoinAdvanced('JOIN', $p['join']) : '') .
                    (isset($p['leftjoin']) ? " " . $this->setJoinAdvanced('LEFT JOIN', $p['leftjoin']) : '') .
                    (isset($p['rightjoin']) ? " " . $this->setJoinAdvanced('RIGHT JOIN', $p['rightjoin']) : '') .
                    (isset($p['innerjoin']) ? " " . $this->setJoinAdvanced('INNER JOIN', $p['innerjoin']) : '') .
                    (isset($p['outerjoin']) ? " " . $this->setJoinAdvanced('OUTER JOIN', $p['innerjoin']) : '') .
                    (isset($p['where']) ? " WHERE " . $this->setWhereAdvanced($p['where']) : '');
                if ($this->getDatabase($db) == 'oci'){
                    $this->requete .= (isset($p['limit']) ? (isset($p['where']) ? ' and ' : ' where ')."rownum between " . $p['limit']->debut . ' and ' . $p['limit']->nombre : '');
                }
                $this->requete .=
                    (isset($p['groupBy']) ? " GROUP BY " . $this->setGroupByAdvanced($p['groupBy']) : '') .
                    (isset($p['having']) ? " HAVING " . $this->setWhereAdvanced($p['having']) : '') .
                    (isset($p['orderBy']) ? " ORDER BY " . $this->setOrderByAdvanced($p['orderBy']) : '');
                if ($this->getDatabase($db) == 'mysql'){
                    $this->requete .= (isset($p['limit']) ? " LIMIT " . ($p['limit']->debut) . (empty($p['limit']->nombre) ? '' : ',' . ($p['limit']->nombre)) : '');
                }
                $this->requete .= (isset($p['union']) ? " UNION " . $this->setUnion($p['union']) : '');
            } else if ($p['instruction'] == 'UPDATE') {
                $this->requete = $p['instruction'] . " " . $p['table'] .
                    " SET " . $this->setSetAdvanced($p['set']) .
                    (isset($p['where']) ? " WHERE " . $this->setWhereAdvanced($p['where']) : '');
            } else if ($p['instruction'] == 'DELETE') {
                $this->requete = $p['instruction'] . " from " . ArrayString::ArrayToString(',', $p['table']) .
                    (isset($p['where']) ? " WHERE " . $this->setWhereAdvanced($p['where']) : '');
            }
            return $this->requete;
        }else{
            return false;
        }
    }

    /**
     * Exécute la requête générée dans la méthode end
     *
     * @param string $db
     * @param string $type
     * @return mixed
     */
    public function exec(string $db = DEFAULT_DATABASE, string $type = "object")
    {
        $this->end($db);
        $query = Connection::getInstance($db)->prepare($this->requete);

        if ($this->params['instruction'] == 'UPDATE') {
            $this->params = [];
            $this->requete = '';
            try{
                $r = $query->execute();
                return $r;
            }catch (\Exception $e){
                foreach ($e as $item) {
                    echo ($item[2]);
                }
                return 0;
            }
        } else if ($this->params['instruction'] == 'SELECT' or $this->params['instruction'] == 'SELECT DISTINCT') {
            $query->execute();
            if ($type == "array") {
                $res = $query->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $res = $query->fetchAll(\PDO::FETCH_OBJ);
            }
            $this->params = [];
            $this->requete = '';
            return $res;
        } else if ($this->params['instruction'] == 'DELETE') {
            $this->params = [];
            $this->requete = '';
            try{
                $r = $query->execute();
                return $r;
            }catch (\Exception $e){
                foreach ($e as $item) {
                    echo ($item[2]);
                }
                return 0;
            }
        }else{
            return false;
        }
    }

    /**
     * Compte le nombre d'enregistrement trouvé par la requête
     *
     * @param string $db
     * @return int
     */
    public function execCount(string $db = DEFAULT_DATABASE)
    {
        $this->end();
        $query = Connection::getInstance($db)->prepare($this->requete);
        $query->execute();
        $res = $query->fetchAll(\PDO::FETCH_OBJ);
        $this->params = [];
        $this->requete = '';
        return count($res);
    }


    /**
     * Enregistre la requête mise en paramètre
     *
     * @param string $query
     * @return void
     */
    public function query(string $query)
    {
        $this->query = $query;
    }

    /**
     * Vide les informations concernant la requête préparée
     *
     * @return string
     */
    public function emptyQuery()
    {
        $query= $this->requete;
        $this->params = [];
        $this->requete = "";
        return $query;
    }

    /**
     * Exécute la requête fournie dans la méthode query
     *
     * @param string $db
     * @return mixed
     */
    public function execQuery(string $db = DEFAULT_DATABASE)
    {
        $this->query = Connection::getInstance($db)->prepare($this->query);
        return $this->query->execute();
    }

    /**
     * Renvoi le resultat de la requête de la méthode query
     *
     * @param string $type
     * @return array|object
     */
    public function resultQuery($type = "object")
    {
        if ($type == "array") {
            return $this->query->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return $this->query->fetchAll(\PDO::FETCH_OBJ);
        }
    }

    /**
     * Retourne le nombre de retour de la requête
     *
     * @return int
     */
    public function resultCountQuery()
    {
        return count($this->query->fetchAll(\PDO::FETCH_OBJ));
    }


    /**
     * Récupère les tables qui sont concernées par la requête
     *
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Récupère les paramètres de la requête
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getBracket(): string
    {
        return $this->bracket;
    }

    /**
     * @param string $bracket
     */
    public function setBracket(string $bracket)
    {
        $this->bracket = $bracket;
    }

    /**
     * @return string
     */
    public function getBracketEnd(): string
    {
        return $this->bracketEnd;
    }

    /**
     * @param string $bracketEnd
     */
    public function setBracketEnd(string $bracketEnd)
    {
        $this->bracketEnd = $bracketEnd;
    }


}
