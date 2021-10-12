<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Topic;
use PDOStatement;

class TopicManager extends Manager{

    /**
     * return a Topic by id
     * @param int $id
     * @return Topic|null
     */
    public static function getById (int $id) : ?Topic{
        $request = DB::getInstance()->prepare("SELECT * FROM topic where tp_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return a Topic by name
     * @param string $name
     * @return Topic|null
     */
    public static function getByUser(string $name): Topic{
        $request = DB::getInstance()->prepare("SELECT * FROM topic where tp_name = :name");
        $request->bindValue(":name",$name);
        return self::getOne($request);
    }

    /**
     * return an array with all the Topic
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM topic");
        return self::getMany($request);
    }

    /**
     * return all topic by category
     * @param int $category_id
     * @return array
     */
    public static function getAllByCategory(int $category_id) : array {
        $request = DB::getInstance()->prepare("SELECT * FROM topic WHERE tp_cat_id = :cat");
        $request->bindValue(":cat",$category_id);
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['name']) || is_null($var['cat_id']) ) {
            $data = self::getById($id);
            if (is_null($var['name'])) {
                $var['name'] = $data->getName();
            }
            if (is_null($var['cat_id']) ) {
                $var['cat_id'] = $data->getCat()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE topic
                    SET tp_name = :name, tp_cat_id = :cat
                    WHERE tp_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":name",mb_strtolower($var['name']));
        $request->bindValue(":cat",intval($var['cat_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param string $name
     * @param int $category_id
     * @return bool
     */
    public static function add(string $name, int $category_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO topic
        (tp_name, tp_cat_id)
        VALUES (:name, :cat)
        ");
        $request->bindValue(":name",$name);
        $request->bindValue(":cat",$category_id);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM topic WHERE tp_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Topic|null
     */
    private static function getOne(PDOStatement $request ) : ?Topic {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            $cat = CategoryManager::getById($data['tp_cat_id']);
            return new Topic(intval($data['tp_id']), $data['tp_name'], $cat);
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
                    $cat = CategoryManager::getById($data['tp_cat_id']);
                    $item = new Topic(intval($data['tp_id']), $data['tp_name'], $cat);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}