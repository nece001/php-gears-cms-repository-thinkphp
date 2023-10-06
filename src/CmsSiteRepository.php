<?php

namespace Nece\Gears\Cms\Repository\ThinkPHP;

use Nece\Gears\Cms\Entity\Site\CmsSiteEntity;
use Nece\Gears\Cms\Entity\Site\ICmsSiteRepository;
use Nece\Gears\Cms\Repository\ThinkPHP\Model\CmsSite;
use Nece\Gears\Paginator;
use Nece\Gears\RepositoryAbstract;

class CmsSiteRepository  extends RepositoryAbstract implements ICmsSiteRepository
{
    /**
     * 根据ID查询
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param integer $id
     *
     * @return CmsSiteEntity
     */
    public function find(int $id): ?CmsSiteEntity
    {
        $model = CmsSite::find($id);
        return $this->modelToEntity($model);
    }

    /**
     * 创建或更新
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param CmsSiteEntity $entity
     *
     * @return integer
     */
    public function createOrUpload(CmsSiteEntity $entity): int
    {
        if ($entity->id) {
            $model = CmsSite::find($entity->id);
        }

        if (!isset($model)) {
            $model = new CmsSite();
        }

        $model->title = $entity->title;
        $model->url = $entity->url;

        $model->save();
        return $model->id;
    }

    /**
     * 删除
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @param array $ids
     *
     * @return integer
     */
    public function delete(array $ids): int
    {
        return CmsSite::whereIn('id', $ids)->delete();
    }

    /**
     * 分页列表
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

        $query = CmsSite::order('id', 'DESC');
        if ($this->hasValue($params, 'title')) {
            $query->whereLike('title', '%' . $this->getValue($params, 'title') . '%');
        }

        $list = $query->paginate($limit, false, array('list_rows' => $page, 'var_page' => 'page'));

        $pager = new Paginator($list->listRows(), $list->total(), $list->currentPage());
        foreach ($list as $item) {
            $pager->addItem($this->modelToEntity($item));
        }

        return $pager;
    }

    /**
     * 全部
     *
     * @Author nece001@163.com
     * @DateTime 2023-10-06
     *
     * @return array
     */
    public function all(): array
    {
        $data = array();
        $items = CmsSite::select();
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
     * @return CmsSiteEntity|null
     */
    private function modelToEntity($model)
    {
        if ($model) {
            $entity = new CmsSiteEntity();

            $entity->id = $model->id;
            $entity->create_time = $model->create_time;
            $entity->update_time = $model->update_time;
            $entity->title = $model->title;
            $entity->url = $model->url;

            return $entity;
        }
        return null;
    }
}
