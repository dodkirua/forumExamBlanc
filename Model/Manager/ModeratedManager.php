<?php

namespace Model\Manager;

use Model\DB;
use Model\Entity\Moderated;
use PDOStatement;

class ModeratedManager extends Manager{

    /**
     * return a Moderated by id
     * @param int $id
     * @return Moderated|null
     */
    public static function getById (int $id) : ?Moderated{
        $request = DB::getInstance()->prepare("SELECT * FROM moderated where md_id= :id");
        $request->bindValue(":id",$id);
        return self::getOne($request);
    }

    /**
     * return a Moderated by user_id
     * @param int $user_id
     * @return Moderated|null
     */
    public static function getByUser(int $user_id){
        $request = DB::getInstance()->prepare("SELECT * FROM moderated where md_user_id = :user");
        $request->bindValue(":user",$user_id);
        return self::getOne($request);
    }

    /**
     * return an array with all the Moderated
     * @return array
     */
    public static function getAll() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM moderated");
        return self::getMany($request);
    }

    /**
     * return all moderated archived
     * @return array
     */
    public static function getAllArchive() : array {
        $request = DB::getInstance()->prepare("SELECT * FROM moderated WHERE md_archived = 1");
        return self::getMany($request);
    }

    /**
     * update on DB with id
     * @param int $id
     * @param array|null $var
     * @return bool
     */
    public static function update(int $id, array $var = null) : bool{
        if (is_null($var['date']) || is_null($var['remark_id']) || is_null($var['reason']) || is_null($var['user_id']) ) {
            $data = self::getById($id);
            if (is_null($var['date'])) {
                $var['date'] = $data->getDate();
            }
            if (is_null($var['remark_id']) ) {
                $var['remark_id'] = $data->getRemark()->getId();
            }
            if (is_null($var['reason']) ) {
                $var['reason'] = $data->getReason();
            }
            if (is_null($var['user_id']) ) {
                $var['user_id'] = $data->getUser()->getId();
            }
        }

        $request = DB::getInstance()->prepare("UPDATE moderated
                    SET md_name = :name, md_archived = :archive, md_description = :desc
                    WHERE md_id = :id
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
        $request = DB::getInstance()->prepare("INSERT INTO moderated
        (md_name, md_archived, md_description)
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
        $request = DB::getInstance()->prepare("DELETE FROM moderated WHERE md_id = :id");
        $request->bindValue(':id',$id);
        return $request->execute();
    }

    /**
     * private request for the getBy
     * @param PDOStatement $request
     * @return Moderated|null
     */
    private static function getOne(PDOStatement $request ) : ?Moderated {
        $request->execute();
        $data = $request->fetch();
        if ($data) {
            return new Moderated(intval($data['md_id']), $data['md_name'], $data['md_archived'], $data['md_description']);
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
                    $item = new Moderated(intval($data['md_id']), $data['md_name'], $data['md_archived'], $data['md_description']);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}