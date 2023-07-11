<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\CmsModelDefinitionEntity;
use Nece\Gears\Cms\Repository\ICmsModelDefinitionRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsModelDefinition;

class CmsModelDefinitionRepository implements ICmsModelDefinitionRepository
{
    /**
     * 查询模型定义
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param string $id
     *
     * @return CmsModelDefinitionEntity|null
     */
    public function find($id)
    {
        $item = CmsModelDefinition::find($id);
        if ($item) {
            $entity = new CmsModelDefinitionEntity($item->title, $item->is_disabled, $item->id);
            $entity->create_time = $item->create_time;
            $entity->update_time = $item->update_time;
            return $entity;
        }

        return null;
    }

    /**
     * 创建或更新模型
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsModelDefinitionEntity $entity
     *
     * @return CmsModelDefinitionEntity
     */
    public function createOrUpdate(CmsModelDefinitionEntity $entity)
    {
        if ($entity) {
            if ($entity->id) {
                $model = CmsModelDefinition::find($entity->id);
            } else {
                $model = new CmsModelDefinition();
            }

            $model->title = $entity->title;
            $model->is_disabled = $entity->is_disabled ? 1 : 0;
            $model->save();

            $entity->id = $model->id;
        }

        return $entity;
    }

    /**
     * 删除模型
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param string $id
     *
     * @return integer
     */
    public function deleteById($id)
    {
        return CmsModelDefinition::where('id', $id)->delete();
    }
}
