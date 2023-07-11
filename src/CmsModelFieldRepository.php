<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\CmsModelFieldEntity;
use Nece\Gears\Cms\Repository\ICmsModelFieldRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsModelField;

class CmsModelFieldRepository implements ICmsModelFieldRepository
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
    public function find($id)
    {
        $item = CmsModelField::find($id);
        if ($item) {
            $entity = new CmsModelFieldEntity();
            $entity->id = $item->id;
            $entity->title = $item->title;
            $entity->create_time = $item->create_time;
            $entity->update_time = $item->update_time;
            $entity->is_disabled = $item->is_disabled;
            $entity->sort = $item->sort;
            $entity->definition_id = $item->definition_id;
            $entity->search_type = $item->search_type;
            $entity->value_type = $item->value_type;
            $entity->value_format = $item->value_format;
            return $entity;
        }

        return null;
    }

    /**
     * 创建或更新模型字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsModelFieldEntity $entity
     *
     * @return CmsModelFieldEntity
     */
    public function createOrUpdate(CmsModelFieldEntity $entity)
    {
        if ($entity) {
            if ($entity->id) {
                $model = CmsModelField::find($entity->id);
            } else {
                $model = new CmsModelField();
            }

            $model->title = $entity->title;
            $model->is_disabled = $entity->is_disabled ? 1 : 0;
            $model->sort = $entity->sort;
            $model->definition_id = $entity->definition_id;
            $model->search_type = $entity->search_type;
            $model->value_type = $entity->value_type;
            $model->value_format = $entity->value_format;
            $model->save();

            $entity->id = $model->id;
        }

        return $entity;
    }

    /**
     * 删除模型字段
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param string $id;
     *
     * @return integer
     */
    public function deleteById($id)
    {
        return CmsModelField::where('id', $id)->delete();
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
    public function deleteByDefinitionId($id)
    {
        return CmsModelField::where('definition_id', $id)->delete();
    }
}
