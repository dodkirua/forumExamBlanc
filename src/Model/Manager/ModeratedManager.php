<?php

namespace Dodkirua\Forum\Model\Manager;

use Dodkirua\Forum\Model\DB;
use Dodkirua\Forum\Model\Entity\Moderated;
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
     * return an array by user_id
     * @param int $user_id
     * @return array
     */
    public static function getAllByUser(int $user_id): array{
        $request = DB::getInstance()->prepare("SELECT * FROM moderated where md_user_id = :user");
        $request->bindValue(":user",$user_id);
        return self::getMany($request);
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
                    SET md_date = :date, md_remark_id = :remark, md_reason = :reason, md_user_id = :user
                    WHERE md_id = :id
                    ");
        $request->bindValue(":id",$id);
        $request->bindValue(":reason",mb_strtolower($var['reason']));
        $request->bindValue(":date",intval($var['date']));
        $request->bindValue(":remark",intval($var['remark_id']));
        $request->bindValue(":user",intval($var['user_id']));

        return $request->execute();
    }

    /**
     * insert  in DB
     * @param int $date
     * @param int $remark_id
     * @param string $reason
     * @param int $user_id
     * @return bool
     */
    public static function add(int $date, int $remark_id, string $reason, int $user_id) : bool {
        $request = DB::getInstance()->prepare("INSERT INTO moderated
        (md_date, md_remark_id, md_reason, md_user_id)
        VALUES (:date, :remark, :reason, :user)
        ");
        $request->bindValue(":reason",mb_strtolower($reason));
        $request->bindValue(":date", $date);
        $request->bindValue(":remark", $remark_id);
        $request->bindValue(":user", $user_id);

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
            $remark = RemarkManager::getById($data['md_remark_id']);
            $user = UserManager::getById($data['md_user_id']);
            return new Moderated(intval($data['md_id']), $data['md_date'],$remark, $data['md_reason'], $user);
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
                    $remark = RemarkManager::getById($data['md_remark_id']);
                    $user = UserManager::getById($data['md_user_id']);
                    $item = new Moderated(intval($data['md_id']), $data['md_date'],$remark, $data['md_reason'], $user);
                    $array[] = $item;
                }
            }
        }
        return $array;

    }
}