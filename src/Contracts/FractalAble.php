<?php

namespace Joselfonseca\LaravelApiTools\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\SerializerAbstract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Joselfonseca\LaravelApiTools\Exceptions\UnTransformableResourceException;

/**
 * Interface FractalAble
 * @package App\Contracts
 */
interface FractalAble
{

    /**
     * Set the transformer to be used in the transformation
     * @return TransformerAbstract
     */
    public function setTransformer();


    /**
     * Sets the serializer to be used in the transformation
     * @return SerializerAbstract
     */
    public function setSerializer();

    /**
     * Transforms a collection into an array using the transformer specified
     * @param Collection $collection
     * @param String|null $resourceKey
     * @param array $meta
     * @return mixed
     */
    public function transformCollection(Collection $collection, $resourceKey = null, $meta = []);


    /**
     * Transforms a model into an array using the transformer specified
     * @param Model $item
     * @param String|null $resourceKey
     * @param array $meta
     * @return mixed
     */
    public function transformItem(Model $item, $resourceKey = null, $meta = []);

    /**
     * Transforms a collection with pagination into an array using the transformer specified
     * @param LengthAwarePaginator $paginator
     * @param String|null $resourceKey
     * @param array $meta
     * @return mixed
     */
    public function transformPaginator(LengthAwarePaginator $paginator, $resourceKey = null, $meta = []);


    /**
     * Applies transformation to the entity, collection or paginator.
     * @param Collection|Model|LengthAwarePaginator $results
     * @param array $meta
     * @return array
     * @throws UnTransformableResourceException
     */
    public function transform($results, $meta = []);
}
