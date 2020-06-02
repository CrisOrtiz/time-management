<?php

namespace App\Packages\KendoGrid;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class KendoGrid
{
    private $params = [];

    private $query;

    private $hasFilters = false;

    public function setParams($params) {
        $this->params = $params;
        return $this;
    }

    public function create(Builder $query)
    {
        $this->query = $query;
        return $this;
    }

    public function getData()
    {
        $totalQuery = clone $this->query;
        $this->applySort();
        $this->applyFilters();
        $this->applyPagination();
        return [
            'data' => $this->query->get(),
            'recordsTotal' => $this->hasFilters ? $this->query->count() : $totalQuery->count()
        ];
    }

    private function applyPagination()
    {
        $take = $this->params['take'] ?? 40;
        $skip = $this->params['skip'] ?? 0;
        if ($skip > 0) {
            $this->query->skip($skip);
        }
        $this->query->take($take);
    }

    private function applySort()
    {
        $sortFields = [];
        if (!isset($this->params['sort'])) {
            return;
        }
        foreach ($this->params['sort'] as $sortModel) {
            $sortFields[$sortModel['field']] = $sortModel['dir'];
        }
        $this->query->sortable($sortFields);
    }

    private function applyFilters()
    {
        $filters = $this->getFilledFilters($this->params['filter']['filters'] ?? []);
        $this->query->where(function ($query) use ($filters) {
            foreach ($filters as $filterModel) {
                $this->hasFilters = true;
                if ($this->isRelationship($filterModel)) {
                    $query->whereHas($this->getRelationshipField($filterModel), function ($query) use ($filterModel) {
                        $query->where($this->getFilterField($filterModel), $this->getFilterOperator($filterModel),  $this->getFilterValue($filterModel));
                    });
                } else {
                    $query->where($this->getFilterField($filterModel), $this->getFilterOperator($filterModel),  $this->getFilterValue($filterModel));
                }
            }
        });
    }

    private function getFilledFilters($filters) {
        $filledFilters = [];
        foreach ($filters as $filterModel) {
            if (!empty($filterModel['value'])) {
                $filledFilters[] = $filterModel;
            }
        }
        return $filledFilters;
    }

    private function isRelationship($fieldModel)
    {
        return count(explode('.', $fieldModel['field'])) > 1;
    }

    private function getRelationshipField($fieldModel)
    {
        return explode('.', $fieldModel['field'])[0];
    }

    private function getFilterField($fieldModel)
    {
        return Arr::last(explode('.', $fieldModel['field']));
    }

    private function getFilterOperator($fieldModel) {
        if ($fieldModel['operator'] === 'contains') {
            return 'LIKE';
        } else {
            return '=';
        }
    }

    private function getFilterValue($fieldModel) {
        if ($fieldModel['operator'] === 'contains') {
            return '%' . $fieldModel['value'] . '%';
        } else {
            return $fieldModel['value'];
        }
    }
}
