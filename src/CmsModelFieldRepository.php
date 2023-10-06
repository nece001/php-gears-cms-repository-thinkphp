<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\Model\Field\CmsModelFieldEntity;
use Nece\Gears\Cms\Entity\Model\Field\ICmsModelFieldRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsModelField;
use Nece\Gears\RepositoryAbstract;

class CmsModelFieldRepository extends RepositoryAbstract implements ICmsModelFieldRepository
{
    /**
     * 查询模型字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param string $id
     *
     * @return CmsModelFieldEntity|null
     */
    public function find($id): ?CmsModelFieldEntity
    {
        $item = CmsModelField::find($id);

        return $this->modelToEntity($item);
    }

    /**
     * 创建或更新模型字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsModelFieldEntity $entity
     *
     * @return integer
     */
    public function createOrUpdate(CmsModelFieldEntity $entity): int
    {
        if ($entity) {
            if ($entity->id) {
                $model = CmsModelField::find($entity->id);
            }

            if (!isset($model)) {
                $model = new CmsModelField();
                $model->definition_id = $entity->definition_id;
            }

            $model->title         = $entity->title;
            $model->is_disabled   = $entity->is_disabled ? 1 : 0;
            $model->sort          = $entity->sort;
            $model->search_type   = $entity->search_type;
            $model->value_type    = $entity->value_type;
            $model->value_format  = $entity->value_format;
            $model->save();

            return $model->id;
        }

        return 0;
    }

    /**
     * 删除模型字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param array $ids
     *
     * @return integer
     */
    public function delete(array $ids): int
    {
        return CmsModelField::whereIn('id', $ids)->delete();
    }

    /**
     * 删除模型的所有字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-11
     *
     * @param string $id
     *
     * @return integer
     */
    public function deleteByDefinitionId($id): int
    {
        return CmsModelField::where('definition_id', $id)->delete();
    }

    /**
     * 定义的字段列表
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param integer $id
     *
     * @return array
     */
    public function listByDefinitionId($id): array
    {
        $data = array();
        $query = CmsModelField::where('definition_id', $id);
        $items = $query->select();

        foreach ($items as $item) {
            $data[] = $this->modelToEntity($item);
        }
        return $data;
    }

    /**
     * 模型转实体
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param \think\model $model
     *
     * @return CmsModelFieldEntity
     */
    private function modelToEntity($model)
    {
        if ($model) {
            $entity = new CmsModelFieldEntity();
            $entity->id            = $model->id;
            $entity->title         = $model->title;
            $entity->create_time   = $model->create_time;
            $entity->update_time   = $model->update_time;
            $entity->is_disabled   = $model->is_disabled;
            $entity->sort          = $model->sort;
            $entity->definition_id = $model->definition_id;
            $entity->search_type   = $model->search_type;
            $entity->value_type    = $model->value_type;
            $entity->value_format  = $model->value_format;

            return $entity;
        }
        return null;
    }
}
