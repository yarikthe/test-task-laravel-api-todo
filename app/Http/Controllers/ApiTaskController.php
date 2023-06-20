<?php

namespace App\Http\Controllers;


use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ApiTaskController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    //
    public function index(Request $request){

        $query = Task::query();

        // Options

        // filter
        $status = $request->input('status');
        $priority = $request->input('priority');
        $title = $request->input('title');

        $sort = $request->input('sort');

        $limit = $request->input('limit', 10);

        if($status){
            $query->where('status', $status);

            if(in_array($status, ['todo', 'done'])){
                $query->where('status', $status);
            }else{
                return $this->errorResponse('Undefined filter option', 'Error option', 401);
            }
        }

        if($priority){
            if(in_array($priority, [1, 2, 3, 4, 5])){
                $query->where('priority', $priority);
            }else{
                return $this->errorResponse('Undefined filter priority option', 'Error filter option', 401);
            }
        }

        if($title){
            $query
                ->where('title', 'LIKE', "%{$title}%");
//                ->orWhere('description', 'LIKE', "%{$title}%");
        }

        if($sort){

            // createdAt
            // completedAt
            // priority

            if($sort == 'createdAt'){
                $query->orderBy('created_at', $request->input('sortValue', 'DESC'));
            }else if($sort == 'completedAt'){
                $query->orderBy('completedAt', $request->input('sortValue', 'DESC'));
            }else if($sort == 'priority'){
                $query->orderBy('priority', $request->input('sortValue', 'DESC'));
            }else{
                return $this->errorResponse('Undefined sort option', 'Error option', 401);
            }

        }

        $data = $query->whereNull('parent_id' )->limit($limit)->where('user_id',auth('sanctum')->user()->id)->get();

        $response = [
            'tasks' => TaskResource::collection($data),
            'total' => $data->count(),
            'limit' => $limit
        ];

        return $this->successResponse($response, 'Get tasks');
    }

    //
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks|max:255',
            'description' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors, 'Error validate', 401);
        }

        $task = Task::create($request->all());

       return $this->successResponse(new TaskResource($task), 'Get tasks');
    }

    //
    public function destroy($id){

        $task = Task::find($id);

        if(is_null($task)){
            return $this->errorResponse('Task not found!', 'Error completed!', 401);
        }

        if($task->status == 'done'){
            return $this->errorResponse('You can not delete completed task!', 'Error completed task', 401);
        }

        $authID = auth('sanctum')->user()->id;

        if($authID != $task->user_id){
            return $this->errorResponse('You can not delete, you not owner!', 'Error', 401);
        }

        if($task->delete())
        {
            return $this->successResponse([], 'Task was deleted successfully!');
        }

        return $this->errorResponse('Error', 'Something wrong... Refresh latter!', 500);
    }

    //
    public function update($id, Request $request){

        $task = Task::find($id);

        if(is_null($task)){
            return $this->errorResponse('Task not found!', 'Error', 401);
        }

        $authID = auth('sanctum')->user()->id;

        if($authID != $task->user_id){
            return $this->errorResponse('You can not updated, you not owner!', 'Error', 401);
        }

        if($task->update($request->all()))
        {
            return $this->successResponse(new TaskResource($task), 'Task was updated successfully!');
        }

        return $this->errorResponse('Error', 'Something wrong... Refresh latter!', 500);
    }

    //
    public function completed($id){

        $task = Task::find($id);

        if(is_null($task)){
            return $this->errorResponse('Task bot found!', 'Error deleted', 401);
        }

        $subTasks = Task::where('parent_id', $task->id)->where('status', 'todo')->get();

        if($subTasks->count() >= 1){
            return $this->errorResponse('Can not completed task. You can have ' . $subTasks->count() . ' open subtasks!', 'Error deleted', 401);
        }

        $authID = auth('sanctum')->user()->id;

        if($authID != $task->user_id){
            return $this->errorResponse('You can not completed, you not owner!', 'Error', 401);
        }

        $task->status = 'done';
        $task->completedAt = Carbon::now();

        if($task->save())
        {
            return $this->successResponse(new TaskResource($task), 'Task was completed successfully!');
        }

        return $this->errorResponse('Error', 'Something wrong... Refresh latter!', 500);
    }
}
