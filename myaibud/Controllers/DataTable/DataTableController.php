<?php

namespace Myaibud\Controllers\DataTable;

use Exception, Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
abstract class DataTableController extends Controller
{
    protected $allowCreation = true;

    protected $allowDeletion = true;

	protected $builder;

    abstract public function builder();

    public function __construct() 
    {
    	$builder = $this->builder();
    	if (!$builder instanceof Builder) {
    		throw new Exception("Entity instance is not an instance of builder", 1);
    		
    	}

        $this->builder = $builder;
    }
/**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumn()),
                'updatable' => array_values($this->getUpdatableColumn()),
                'records' => $this->getRecords($request),
                'allow' => [
                    'creation' => $this->allowCreation,
                    'deletion' => $this->allowDeletion
                ],
                'form' => [
                    'input-types' => $this->getUpdatableColumnInputTypes(),
                ]
            ]
        ]);
    }

    /**
     * [update description]
     * @param  [type]  $id      [description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update($id, Request $request)
    {
        $this->builder->find($id)->update($request->only($this->getUpdatableColumn()));
    }

    /**
     * Store the record
     * @param string $value [description]
     */
    public function store(Request $request)
    {
        if (!$this->allowCreation) {
            return;
        }

        $this->builder->create($request->only($this->getUpdatableColumn()));
    }

    public function destroy($id, Request $request)
    {
        $this->builder->find($id)->delete();
    }
    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getRecords(Request $request)
    {
        return $this->builder->limit($request->limit)->orderBy('id')->get(
            $this->getDisplayableColumn()
        );
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getDisplayableColumn()
    {
        return array_diff($this->getTableColumns(), $this->builder->getModel()->getHidden());
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getUpdatableColumn()
    {
        return $this->getDisplayableColumn();
    }

    public function getTableColumns()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

}
