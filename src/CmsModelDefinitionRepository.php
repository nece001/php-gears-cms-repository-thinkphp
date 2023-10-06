<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\Model\Definition\CmsModelDefinitionEntity;
use Nece\Gears\Cms\Entity\Model\Definition\ICmsModelDefinitionRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsModelDefinition;
use Nece\Gears\Paginator;
use Nece\Gears\RepositoryAbstract;

class CmsModelDefinitionRepository extends RepositoryAbstract implements ICmsModelDefinitionRepository
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
    public function find($id): ?CmsModelDefinitionEntity
    {
        $model = CmsModelDefinition::find($id);
        return $this->modelToEntity($model);
    }

    /**
     * 创建或更新模型
     *
     * @Author nece001@163.com
     * @DateTime 2023-07-08
     *
     * @param CmsModelDefinitionEntity $entity
     *
     * @return int
     */
    public function createOrUpdate(CmsModelDefinitionEntity $entity): int
    {
        if ($entity) {
            if ($entity->id) {
                $model = CmsModelDefinition::find($entity->id);
            }

            if (!isset($model)) {
                $model = new CmsModelDefinition();
            }

            $model->title       = $entity->title;
            $model->site_id     = $entity->site_id;
            $model->is_disabled = $entity->is_disabled ? 1 : 0;
            $model->save();

            $entity->id = $model->id;
            return $model->id;
        }

        return 0;
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
    public function delete(array $ids): int
    {
        return CmsModelDefinition::whereIn('id', $ids)->delete();
    }

    /**
     * 分页
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param array $params
     *
     * @return Paginator
     */
    public function pagedList(array $params): Paginator
    {
        $page = $this->getValue($params, 'page', 1);
        $limit = $this->getValue($params, 'limit', 10);

        $query = CmsModelDefinition::order('id', 'DESC');

        if ($this->hasValue($params, 'keyword')) {
            $query->whereLike('title|key_name', '%' . $params['keyword'] . '%');
        }

        $list = $query->paginate($limit, false, array('list_rows' => $page, 'var_page' => 'page'));

        $pager = new Paginator($list->listRows(), $list->total(), $list->currentPage());
        foreach ($list as $item) {
            $pager->addItem($this->modelToEntity($item));
        }

        return $pager;
    }

    /**
     * 模型转实体
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param \think\model $model
     *
     * @return CmsModelDefinitionEntity|null
     */
    private function modelToEntity($model)
    {
        if ($model) {
            $entity              = new CmsModelDefinitionEntity();
            $entity->id          = $model->id;
            $entity->create_time = $model->create_time;
            $entity->update_time = $model->update_time;
            $entity->is_disabled = $model->is_disabled;
            $entity->title       = $model->title;
            $entity->site_id     = $model->site_id;

            return $entity;
        }
        return null;
    }
}
