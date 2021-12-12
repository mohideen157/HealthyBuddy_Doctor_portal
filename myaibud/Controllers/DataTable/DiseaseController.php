<?php

namespace Myaibud\Controllers\DataTable;

use App\Disease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiseaseController extends DataTableController
{
	public function builder()
	{
		return Disease::query();
	}

	/**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getDisplayableColumn()
    {
        return [
            'id', 'name', 'slug', 'description'
        ];
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getUpdatableColumn()
    {
        return [
            'name', 'slug', 'description'
        ];
    }

    public function store(Request $request)
    {
        if (!$this->allowCreation) {
            return;
        }

        if (!empty($request->slug)) {
        	$slug = str_replace(" ", "-", strtolower($request->slug));
        	$request->merge(array('slug' => $slug));
        }

        $this->validate($request, [
            'name' => 'required',
            'slug' => 'unique:allergies'
        ]);

        $this->builder->create($request->only($this->getUpdatableColumn()));
    }

    /**
     * [update description]
     * @param  [type]  $id      [description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if (!empty($request->slug)) {
        	$allergy = $this->builder->find($id);
        	
        	$slug = str_replace(" ", "-", strtolower($request->slug));
        	$request->merge(array('slug' => $slug));

        	if ($allergy->slug !== $request->slug) {
        		$this->validate($request, [
		            'slug' => 'unique:allergies'
		        ]);	
        	}
        }

        $this->builder->find($id)->update($request->only($this->getUpdatableColumn()));
    }

    /**
     * [getUpdatableColumnInputTypes description]
     * @return [type] [description]
     */
    public function getUpdatableColumnInputTypes()
    {
        $inputTypes = [];
        
        foreach ($this->getUpdatableColumn() as $key => $column) {
            if ($column == 'created_at' || $column == 'updated_at') {
                $inputTypes[$column] = 'date';
            } else {
                $inputTypes[$column] = 'text';
            }
        }

        return $inputTypes;
    }

    public function getAllRequestsForSelectDropdown()
    {
    }
}