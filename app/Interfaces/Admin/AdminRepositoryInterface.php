<?php

namespace App\Interfaces\Admin;

use Illuminate\Http\Request;

interface  AdminRepositoryInterface
{

    public function get(Request $request, $with = [], $withCount = [], $filter = '', $paginate = 20);

    public function store(Request $request, $data=null) ;

    public function update($id, Request $request, $data=null) ;

    public function show($id, $with = [], $withCount = []);

    public function data($query, $request, $filter = '', $paginate = '', $whereHas = []);

    public function delete($id);

    public function setDataPayload(Request $request = null, $type = 'store');
}
