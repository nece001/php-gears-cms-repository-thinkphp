<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\CmsSubjectCategoryEntity;
use Nece\Gears\Cms\Repository\ICmsSubjectCategoryRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsSubjectCategory;

class CmsSubjectCategoryRepository implements ICmsSubjectCategoryRepository
{
    /**
     * 查询模型定义
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param string $id
     *
     * @return CmsSubjectCategoryEntity|null
     */
    public function find($id)
    {
        $item = CmsSubjectCategory::find($id);
        if ($item) {
            return $this->modelToEntity($item);
        }
        return null;
    }

    /**
     * 创建或更新模型
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsSubjectCategoryEntity $entity
     *
     * @return CmsSubjectCategoryEntity
     */
    public function createOrUpdate(CmsSubjectCategoryEntity $entity)
    {
        if ($entity) {
            if ($entity->id) {
                $item = CmsSubjectCategory::find($entity->id);
            } else {
                $item = new CmsSubjectCategory();
            }

            $item->model_definition_id = $entity->model_definition_id;
            $item->parent_id = $entity->parent_id;
            $item->node_level = $entity->node_level;
            $item->node_no = $entity->node_no;
            $item->node_path = $entity->node_path;
            $item->title = $entity->title;
            $item->save();

            $entity->id = $item->id;
            return $entity;
        }

        return null;
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
        return CmsSubjectCategory::where('id', $id)->delete();
    }

    /**
     * 获取父级所有子级
     *
     * @Author nece001@163.com
     * @DateTime 2023-05-11
     *
     * @param string $node_no
     *
     * @return array
     */
    public function getAllChildsByParentNodeNo($node_no)
    {
        $data = array();
        $query = CmsSubjectCategory::whereLike('node_no', $node_no . '%')->order('node_no');
        $items = $query->select();

        foreach ($items as $item) {
            $data[] = $item->toArray();
        }

        return $data;
    }

    /**
     * 获取ID节点的前一兄弟节点
     *
     * @Author nece001@163.com
     * @DateTime 2023-05-11
     *
     * @param int $id
     *
     * @return array
     */
    public function getPreviousSibling($id)
    {
        $item = $this->find($id);
        $query = CmsSubjectCategory::where('parent_id', $item->parent_id)->where('node_no', '<', $item->node_no)->order('node_no', 'DESC');

        $item = $query->find();
        return $item ? $item->toArray() : array();
    }

    /**
     * 获取ID节点的后一兄弟节点
     *
     * @Author nece001@163.com
     * @DateTime 2023-05-11
     *
     * @param int $id
     *
     * @return array
     */
    public function getNextSibling($id)
    {
        $item = $this->find($id);
        $query = CmsSubjectCategory::where('parent_id', $item->parent_id)->where('node_no', '>', $item->node_no)->order('node_no');

        $item = $query->find();
        return $item ? $item->toArray() : array();
    }

    /**
     * 获取父级子节点的最大节点序号
     *
     * @Author nece001@163.com
     * @DateTime 2023-05-11
     *
     * @param int $parent_id
     *
     * @return array 
     */
    public function getChildLastNodeOfParent($parent_id)
    {
        $query = CmsSubjectCategory::where('parent_id', $parent_id)->order('node_no', 'DESC');

        $item = $query->find();
        return $item ? $item->toArray() : array();
    }

    /**
     * 模型转实体
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-12
     *
     * @param \think\model $model
     *
     * @return CmsSubjectCategoryEntity|null
     */
    private function modelToEntity($model)
    {
        if ($model) {
            $entity = new CmsSubjectCategoryEntity();
            $entity->id = $model->id;
            $entity->create_time = $model->create_time;
            $entity->update_time = $model->update_time;
            $entity->model_definition_id = $model->model_definition_id;
            $entity->parent_id = $model->parent_id;
            $entity->node_level = $model->node_level;
            $entity->node_no = $model->node_no;
            $entity->node_path = $model->node_path;
            $entity->title = $model->title;

            return $entity;
        }
        return null;
    }
}
