# Laravel API Tools - Responder

Laravel API Tools comes with a trait to build responses out of your controllers. To use it add the trait to your controller:

```php
	use Joselfonseca\LaravelApiTools\Traits\ResponderTrait;
 
	/**
	 * Description of UserController
	 *
	 * @author josefonseca
	*/
	class UserController extends Controller
	{
	    use ResponderTrait;
	}
```
## Available functions:

```php
	// Returns a collection with pagination
	public function responseWithPaginator($limit, $model, $transformer, $urlPath, $append);
	// Returns a single item transformed
	public function responseWithitem($model, $transformer);
	// Returns a collection without pagination
	public function responseWithCollection($model, $transformer);
	// Returns a no content response
	public function responseNoContent();
	// Returns a 401 unauthorized response with custom message
	public function errorUnauthorized($message = null);
	// Returns a 500 error response
	public function errorInternal($message = null);
	// Returns an array as a JSON response
	public function simpleArray(array $array = []);
	// returns a created response
	public function respondCreated();
```

## Exceptions

```php
	Joselfonseca\LaravelApiTools\Exceptions\ValidationException;
	Joselfonseca\LaravelApiTools\Exceptions\AuthorizationException;
	Joselfonseca\LaravelApiTools\Exceptions\AclException;
	Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException;
```
you can also make use of the exceptions used by dingo as per this documentation [https://github.com/dingo/api/wiki/Errors-And-Error-Responses](https://github.com/dingo/api/wiki/Errors-And-Error-Responses)

Here is a Controller that uses the responder trait as an example.

```php
	namespace Joselfonseca\LaravelAdminRest\Http\Controllers\Users;
	 
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Joselfonseca\LaravelAdminRest\Services\Users\Transformers\UserTransformer;
	use Joselfonseca\LaravelAdmin\Http\Controllers\Controller;
	use Joselfonseca\LaravelAdminRest\Http\Requests\Users\UpdateUserRequest;
	use Joselfonseca\LaravelAdmin\Services\Users\UserRepository;
	use Joselfonseca\LaravelApiTools\Traits\ResponderTrait;
	use Joselfonseca\LaravelAdminRest\Http\Requests\Users\CreateUserRequest;
	use Joselfonseca\LaravelAdminRest\Http\Requests\Users\DeleteUserRequest;
	use Joselfonseca\LaravelAdminRest\Http\Requests\Users\ShowUserRequest;
	use Joselfonseca\LaravelAdminRest\Http\Requests\Users\ListsUsersRequest;
	use Joselfonseca\LaravelApiTools\Exceptions\ApiModelNotFoundException;
	 
	/**
	 * Description of UserController
	 *
	 * @author josefonseca
	 */
	class UserController extends Controller
	{
	 
	    use ResponderTrait;
	 
	    protected $model;
	    protected $transformer;
	    protected $repository;
	 
	    public function __construct(UserTransformer $t, UserRepository $r)
	    {
	        $model             = \Config::get('auth.model');
	        $this->model       = new $model;
	        $this->transformer = $t;
	        $this->repository  = $r;
	    }
	 
	    public function index(ListsUsersRequest $request)
	    {
	        if (!$request->has('limit')) {
	            return $this->responseWithCollection($this->model,
	                    $this->transformer);
	        }
	        return $this->responseWithPaginator($request->get('limit'), $this->model, $this->transformer);
	    }
	 
	    public function store(CreateUserRequest $request)
	    {
	        $user = $this->repository->create($request->all());
	        return $this->responseWithItem($user, $this->transformer);
	    }
	 
	    public function show(ShowUserRequest $request, $id)
	    {
	        try{
	            $user = $this->model->findOrFail($id);
	        }catch (ModelNotFoundException $e){
	            throw new ApiModelNotFoundException;
	        }
	        return $this->responseWithItem($user, $this->transformer);
	    }
	 
	    public function update(UpdateUserRequest $request, $id)
	    {
	        try{
	            $user = $this->model->findOrFail($id);
	        }catch (ModelNotFoundException $e){
	            throw new ApiModelNotFoundException;
	        }
	        if ($request->get('email') !== $user->email) {
	            try {
	                $this->repository->updateWithEmail($user->id, $request->all());
	            } catch (\Exception $e) {
	                throw new \Dingo\Api\Exception\UpdateResourceFailedException('Validation Error',
	                ['email' => trans('LaravelAdmin::laravel-admin.emailTaken')]);
	            }
	        } else {
	            $this->repository->update($user->id, $request->all());
	        }
	        return $this->responseNoContent();
	    }
	 
	    public function destroy(DeleteUserRequest $request, $id)
	    {
	        $user = $this->model->findOrFail($id);
	        $this->repository->deleteUser($user);
	        return $this->responseNoContent();
	    }
	}
```