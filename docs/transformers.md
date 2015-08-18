# Laravel API Tools - Transformers

Laravel API tools uses transformers to create complex data output, to accomplish that the package uses Fractal, a PHP League package developed by Phill Sturgeon.

Say you have a model and that model needs to be represented in JSON, but before that some formatting has to be done, or maybe some casting. To accomplish that in a very good and extensible way, you need to create a transformer, to do that create a class that extends League\Fractal\TransformerAbstract and implement a transform method.

```php
	namespace Joselfonseca\LaravelAdminRest\Services\Users\Transformers;
	 
	 
	use League\Fractal;
	use App\User;
	/**
	 * Description of UserTransformer
	 *
	 * @author josefonseca
	 */
	class UserTransformer extends Fractal\TransformerAbstract
	{
	    public function transform(User $user)
	    {
	        return [
	            'id' => (int) $user->id,
	            'name' => $user->name,
	            'email' => $user->email,
	            'created_at' => $user->created_at,
	            'updated_at' => $user->updated_at
	        ];
	    }
	}
```
The transformer should return an array with the data that needs to be sent back to the client.