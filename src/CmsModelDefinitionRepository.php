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
            $entity = new CmsModelDefinitionEntity();
            $entity->id = $item->id;
            $entity->title = $item->title;
            $entity->create_time = $item->create_time;
            $entity->update_time = $item->update_time;
            $entity->is_disabled = $item->is_disabled;
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
     * @return void
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
        }
    }

    /**
     * 删除模型
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsModelDefinitionEntity $definition
     *
     * @return void
     */
    public function delete(CmsModelDefinitionEntity $definition)
    {
        CmsModelDefinition::where('id', $definition->id)->delete();
    }
}
