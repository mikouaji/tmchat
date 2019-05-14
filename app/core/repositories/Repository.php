<?php
/**
 * Created by PhpStorm.
 * User: mikouaji
 * Date: 2/22/19
 * Time: 6:32 PM
 */

namespace app\core\repositories;

class Repository
{
	protected $model;

	/**
	 * @param int $id
	 * @return object|NULL
	 */
	public function findOneById(int $id)
	{
		return $this->model->findOne($id);
	}

	/**
	 * @param object|NULL $entity
	 * @return bool
	 */
	public function delete(object $entity = NULL) : bool
	{
		if(is_null($entity)) return FALSE;
		return $entity->delete();
	}

	/**
	 * @param array|NULL $params
	 * @param bool $hideIds
	 * @param string $hashsalt
	 * @return array
	 */
	public function findAll(array $params = NULL, bool $hideIds = FALSE, string $hashsalt = NULL) : array {
		if(is_null($params))
			$params = [];
		$entities = $this->model->findAll($params);
		if($hideIds)
			foreach ($entities as &$entity)
				$entity->hideId($hashsalt);
		return $entities;
	}
}
