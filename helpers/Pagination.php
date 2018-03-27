<?php
/**
 * Created by PhpStorm.
 * User: Edogawa
 * Date: 30/12/2017
 * Time: 15:29
 */

namespace Edogawa\Helpers;


use Edogawa\Core\App\App;
use Edogawa\Core\Requete\RequestDataInterface;

/**
 * Class Pagination
 * @package Edogawa\Helpers
 * @author     Cédric SOEDJEDE <soedjedefrido@gmail.com>
 * @copyright  2018 Cédric SOEDJEDE
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link       http://www.edframework.com
 * @since      Version 1.0
 */
class Pagination
{

    /**
     * Définit une pagination
     *
     * @param RequestDataInterface $request
     * @param string $db
     * @param string $table
     * @return array
     *  (
     *      Données provenant d'une table : array $table_data
     *      Nombre de page  : int $number_page
     *      Nombre par page : int $number_per_page
     *      Champ de tri : string $sort
     *      Nombre total d'élément : int $total_number
     *      Page courante : int $page
     *      Direction de tri : string $dir
     *
     *  )
     */
    public static function setPagination(RequestDataInterface $request , string $db , string $table)
    {
        $pagination_number = App::query()
            ->select($table)
            ->champ('count(*)' , 'nombre')
            ->exec($db , 'array');

        $number_per_page = (isset($request->getRequests()['nbp'])) ? intval($request->getRequests()['nbp']) : 10;
        $number_per_page = ($number_per_page == 0 ? 10 : $number_per_page);
        $page = (isset($request->getRequests()['page'])) ? intval($request->getRequests()['page']) : 1;
        $page = ($page == 0 ? 1 : $page);
        $sort = $request->getRequests()['sort'] ?? "";
        $direction = (isset($request->getRequests()['dir']) and $request->getRequests()['dir'] == "down") ? "DESC" : "ASC";

        $number_page = (int) ($pagination_number[0]['nombre'] / $number_per_page) + 1;
        $page = ($page > $number_page) ? 1 : $page;
        $page_ = $page - 1;

        $data_page = App::query()
            ->select($table)
            ->champ('*')
            ->limit( $page_ * $number_per_page , $number_per_page);
        if (!empty($sort)){
            $data_page->orderBy($sort , $direction);
        }
        $data_page = $data_page->exec($db , 'array');

        $data["table_data"] = $data_page;
        $data["number_page"] = $number_page;
        $data["number_per_page"] = $number_per_page;
        $data['sort'] = $sort;
        $data['total_number'] = $pagination_number[0]['nombre'];
        $data['page'] = $page;
        $data['dir'] = $request->getRequests()['dir'] ?? 'up';
        return $data;
    }

}