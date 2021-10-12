<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Category;
use PDOStatement;

class CategoryManager extends Manager{

    /**
     * return a Category by id
     * @param int $id
     * @return Category|null
     */
    public static function getById (int $id) : ?Category{
        $request = DB::getInstance()->prepare("SELECT * FROM category where ct_id = :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return a Category with a name
     * @param string $name
     * @return Category|null
     */
    public static function getByName(string $name){
        $request = DB::getInstance()->prepare("SELECT * FROM category where ct_name = :name");
        $request->bindValue(":name",$name);
        return self::getOne($request);
    }

    /**
     * return an array with all the Category
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM category");
        return self::getMany($request);
    }

    /**
     * return all category archived
     * @return array
     */
    public static function getAllArchive() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM category WHERE ct_archived = 1");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['name']) || is_null($var['archived']) || is_null($var['description']) ) {
            $data = self::getById($id);
            if (is_null($var['name'])) {
                $var['name'] = $data->getName();
            }
            if (is_null($var['archived']) ) {
                $var['archived'] = $data->getArchived();
            }
            if (is_null($var['description']) ) {
                $var['description'] = $data->getDescription();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE category
                    SET ct_name = :name, ct_archived = :archive, ct_description = :desc
                    WHERE ct_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":name",mb_strtolower($var['name']));
        $request->bindValue(":archive",intval($var['archived']));
        $request->bindValue(':desc', mb_strtolower($var['description']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param string $name
     * @param string $description
     * @param int $archive
     * @return bool
     */
    public static function add(string $name, string $description, int $archive = 0) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO category
        (ct_name, ct_archived, ct_description)
        VALUES (:name, :archive, :desc)
        ");
        $request->bindValue(":name",$name);
        $request->bindValue(":archive",$archive);
        $request->bindValue(":desc",$description);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM category WHERE ct_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Category|null
     */
    private static function getOne(PDOStatement $request ) : ?Category {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            return new Category(intval($data['ct_id']), $data['ct_name'], $data['ct_archived'], $data['ct_description']);
        }
        return null;
    }

    /**
     * private request for the getAll
     * @param PDOStatement $request
     * @return array
     */
    private static function getMany(PDOStatement $request) : array {
        $array = [];
        $result = $request->execute();
        if ($result){
            $datum = $request->fetchAll();
            if ($datum) {
                foreach ($datum as $data) {
                    $item = new Category(intval($data['ct_id']), $data['ct_name'], $data['ct_archived'], $data['ct_description']);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}