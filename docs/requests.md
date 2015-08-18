# Laravel API Tools - Requests

Laravel API tools provides a request class that you can use to return JSON responses in case the form validation fails. To use this feature, make sure your request class extends Joselfonseca\LaravelApiTools\Http\Requests\ApiRequest. Doing so, any time the form validation performed by the form request class fails, it will render the exception in a very friendly JSON response with the appropriate status code.

Here is an example of a request.

```php
 
	namespace App\Http\Requests\Admin;
	 
	use Joselfonseca\LaravelApiTools\Http\Requests\ApiRequest as Request;
	 
	class AtpConfigUpdate extends Request
	{
	 
	    /**
	     * Determine if the user is authorized to make this request.
	     *
	     * @return bool
	     */
	    public function authorize()
	    {
	        return true;
	    }
	 
	    /**
	     * Get the validation rules that apply to the request.
	     *
	     * @return array
	     */
	    public function rules()
	    {
	        return [
	            'price' => 'required',
	            'min_proteins_to_add' => 'required',
	            'max_proteins_to_add' => 'required',
	            'min_veggies_to_add' => 'required',
	            'max_veggies_to_add' => 'required',
	            'min_carbohydrates_to_add' => 'required',
	            'max_carbohydrates_to_add' => 'required'
	        ];
	    }
	}
```
