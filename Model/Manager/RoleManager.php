<?php

namespace Model\Manager;

use Model\DB;
use Model\Entity\Role;
use PDOStatement;

class RoleManager extends Manager{

    /**
     * return a Role by id
     * @param int $id
     * @return Role|null
     */
    public static function getById (int $id) : ?Role{
        $request = DB::getInstance()->prepare("SELECT * FROM role where rl_id = :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }


    /**
     * return an array with all the Role
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM role");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['name']) ) {
            $data = self::getById($id);
            $var['name'] = $data->getName();
        }

        $request = DB::getInstance()->prepare("UPDATE role
                    SET rl_name = :name
                    WHERE rl_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":name",mb_strtolower($var['name']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param string $name
     * @return bool
     */
    public static function add(string $name) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO role
        (rl_name)
        VALUES (:name)
        ");
        $request->bindValue(":name",$name);

        return $request->execute();
    }

    /**
     * delete  by id
     * @param int $id
     * @return bool
     */
    public static function delete(int $id) : bool {
        $request = DB::getInstance()->prepare("DELETE FROM role WHERE rl_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Role|null
     */
    private static function getOne(PDOStatement $request ) : ?Role {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            return new Role(intval($data['rl_id']), $data['rl_name']);
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
                    $item = new Role(intval($data['rl_id']), $data['rl_name']);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}